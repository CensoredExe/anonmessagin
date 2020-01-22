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
    $sql = "UPDATE `users` SET `user_type`='admin' WHERE `user_id`='$id'";
    if(mysqli_query($conn, $sql)){
        echo "Promoted";
        addLog($_SESSION['user_id']." Just promoted a user with the uid: ".$id);
    }else {
        echo "ERROR PROMOTING USER";
    }
?>