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
            <h1 style="font-weight:300;">Admin Panel - Mastermind</h1>
            <br><hr><br>
            <h3>DO NOT ABUSE THIS!</h3>
            <p>This feature should only be used in extremely small quantities for admins, with a max of 500 added a week per staff member.</p>
            <p>The intended purpose is to add points to users accounts who have helped the website, or lost points due to a bug.</p>
            <br><hr><br>
            <h3>Add points</h3>
            <form method="POST">
                <input type="text" placeholder="uid" name="uid" required>
                <input type="text" placeholder="num of points" name="points" required>
                <br>
                <button type="submit" name="submit">add points</button>
            </form>
            <?php
            if(isset($_POST['submit'])){
                $uid = mysqli_real_escape_string($conn, $_POST['uid']);
                $points = mysqli_real_escape_string($conn, $_POST['points']);
                if($points > 10000){
                    echo "Dont enter a number too high....";
                    exit();
                }else {
                    addPoints($uid, $points);
                    echo "Done";
                }
            }
            ?>
            <br><hr><br>
            <h3>Take points</h3>
            <form method="POST">
                <input type="text" placeholder="uid" name="uidtake" required>
                <input type="text" placeholder="num of points" name="pointstake" required>
                <br>
                <button type="submit" name="submittake">take points</button>
            </form>
            <?php
            if(isset($_POST['submittake'])){
                $uid = mysqli_real_escape_string($conn, $_POST['uidtake']);
                $points = mysqli_real_escape_string($conn, $_POST['pointstake']);
                if($points > 10000){
                    echo "Dont enter a number too high....";
                    exit();
                }else {
                    subtractPoints($uid, $points);
                    echo "Done";
                }
            }
            ?>
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