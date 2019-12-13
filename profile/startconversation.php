<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    if(isset($_GET['sender']) AND isset($_GET['recipient'])){
        $sender = mysqli_real_escape_string($conn, $_GET['sender']);
        $recipient = mysqli_real_escape_string($conn, $_GET['recipient']);
        if($sender == $recipient){
            echo "<script>window.location = '../index.php'</script>";
            exit();
        }
        $sql = "SELECT * FROM `conversations` WHERE `conv_sender` = '$sender' AND `conv_recipient`='$recipient' OR `conv_sender` = '$recipient' AND `conv_recipient` ='$sender'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            // Conv already exists.
            while($row = mysqli_fetch_assoc($result)){
                $url = "../chat/index.php?id=".$row['conv_id'];
            }
            echo "<script>window.location = '$url'</script>";
            exit();
        } 
        $sql = "INSERT INTO `conversations` (`conv_sender`, `conv_recipient`, `most_recent`) VALUES ('$sender', '$recipient', 'none')";
        if(mysqli_query($conn, $sql)){
            echo "<script>window.location='../dashboard/'</script>";
            addPoints($_SESSION['user_id'], 5);
            addPoints($recipient, 3);
        }else {
            echo "Error";
        }
    }else {
        echo "Error, neccersary id's havent been given.";
    }
?>