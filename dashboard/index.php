<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AnonMessaging - Fully anonymous messaging site</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    
    <div class="main-column">
        <div class="introduction">
            <h1 style="font-weight:300;font-size:50px;">AnonDashboard</h1>
            <p>See new messages or start a conversation.</p>
            <p>Welcome back, <?php echo $_SESSION['user_name']; ?></p>
        </div>
        <div class="right-column">
            <h2 style="font-weight:300;">Actions</h2>
            <hr>
            <ul>
                <li><a href="../logout/">Logout</a></li>
                <li><a href="#">Add a friend</a></li>
            </ul>
        </div>
    </div>
    
    
</body>
</html>