<?php
    session_start();
    include_once "../includes/functions.php";
    if(isset($_SESSION['user_id'])){
        addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") logged out");
    }
    session_unset();
    session_destroy();
    header("Location: ../login/");
?>