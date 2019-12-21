<?php

    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    checkBan($_SESSION['user_id']);

    if(!isset($_GET['id'])){
        echo "<script>window.location='../'</script>";
        exit();
    }
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM `conversations` WHERE `conv_id`='$id';";
    
    $result = mysqli_query($conn, $sql);
    
    
    
    if(mysqli_num_rows($result) == 1){
       
        while($row = mysqli_fetch_assoc($result)){
            if($user_id == $row['conv_sender']){
                deleteConv($id);
                echo "<script>window.location='../'</script>";
            }else if ($user_id == $row['conv_recipient']){
                deleteConv($id);
                echo "<script>window.location='../'</script>";
            }else {
                echo "You dont have perms";
            }
        }

    }else { 
        echo "Doesnt exist";
    }
?>