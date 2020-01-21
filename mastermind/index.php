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
            <h1 style="font-weight:300;">Admin Panel - Mastermind</h1>
            <br><hr><br>
            <h3>What do you wish to do?</h3>
            <ul>
                <li><a href="#">Logs</a></li>
                <li><a href="#">Suggestions</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Ban a user</a></li>
            </ul>
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