<?php
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    session_start();
    if(!isset($_SESSION['user_id'])){
        echo "<script>window.location = '../login/'</script>";
        exit();
    }
    if($_SESSION['user_type'] == 'user'){
        echo "<script>window.location = '../login/'</script>";
        exit();
    }else {
        if(!isset($_GET['id'])){
            echo "<script>window.location = 'index.php'</script>";
            exit(); 
        }
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "DELETE FROM `global` WHERE `msg_id`='$id'";
        
        if(mysqli_query($conn, $sql)){
            addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") deleted a message from global");
            echo "<script>window.location = 'index.php'</script>";
        }else {
            echo "Error, speak to webmaster";
        }
    }
?>