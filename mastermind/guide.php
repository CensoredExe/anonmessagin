<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        // User not logged in
        header("Location: ../");
    }else if($_SESSION['user_type'] == 'user') {
        // Not admin
        echo "Scum! Trying to access the admin panel without access!";
        exit();
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
            <h1 style="font-weight:300;"><a style="color:#000;text-decoration:none" href="index.php">Admin Panel - Mastermind</a></h1>
            <br><hr><br>
            <p>Only rules are Harrasment and any form of child pornography distribution, including but not limited to the sale there of.<br>Always attempt to message an individual for harrasment rule breaks, however for child pornorgrapy, ban them.</p>
            <p>Aswell as this, if someone is spamming the Global chat, message them a warning, or ban them as you see appropriately. Everything is logged, and I will check all bans you make, if one is innapropriate, you will be banned and removed from staff.</p>
        </div>
        <div class="right-column">
            <h2 style="font-weight:300;">Actions</h2>
            <hr>
            <ul>
            <li><a href="../">Dashboard</a></li>
                <li><a href="../profile/index.php?id=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
                <li><a href="../logout">Logout</a></li>
                <li><a href="../users/index.php">Users</a></li>
                <li><a href="../leaderboard/">Leaderboard</a></li>
                <li><a href="../global/">Global chat</a></li>
                <li><a href="../suggestions/">Suggestions</a></li>
                
            </ul>
        </div>
    </div>
</body>
</html>