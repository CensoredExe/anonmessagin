<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: ../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    if($_SESSION['user_type'] == 'user'){
        echo "You dont have permission!";
        exit();
    }
    if(!isset($_GET['id'])){
        echo "ID for ban not specified.";
        exit();
    }
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM `users` WHERE `user_id`='$id' LIMIT 1";
    if(mysqli_query($conn, $sql)){
        echo "Account banned and logged, please PM your Head Admin with a reason for the ban, as all bans are investigated.";
        addLog($_SESSION['user_id']." Just banned a user with the uid: ".$id);
    }else {
        echo "ERROR BANNING USER";
    }
?>