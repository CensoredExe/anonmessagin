<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        // User not logged in
        header("Location: ../");
    }else if($_SESSION['user_type'] == 'user') {
        // Not admin
        echo "Scum! Trying to access the admin panel without access!";
    }
?>