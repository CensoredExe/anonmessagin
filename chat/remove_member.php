<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    if(!isset($_GET['id'])){
        echo "<script>window.location = '../index.php'</script>";
        exit();
    }
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $sql = "SELECT * FROM `gc_table` WHERE `g_id`='$id'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $name = $row['g_name'];
    }
    $user_id = $_SESSION['user_id'];
    
    checkBan($_SESSION['user_id']);
    if(falseMembership($user_id, $id)){
        echo "No membership to this groupchat";
        exit();
    }
    
    $sql = "DELETE FROM `gc_members` WHERE `g_gc`='$id' AND `g_user`='$uid';";
    if(mysqli_query($conn, $sql)){
        $url = "members.php?id=" + $id;
        echo "<script>window.location = '../dashboard/'</script>";
    }else {
        echo "error";
    }
?>
