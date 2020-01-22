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
            <table style="width: 100%;" border="1">
                <thead>
                    <th>ID</th>
                    <th>Date</th>
                    <th>User</th>
                    <th>Suggestion</th>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `suggestions` ORDER BY `s_id` DESC LIMIT 1000";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr style="max-height:20px;overflow:auto;max-width:100%;">
                            <td><?php echo $row['s_id']; ?></td>
                            <td><?php echo $row['s_date']; ?></td>
                            <td><?php echo findName($row['s_user']); ?> (<?php echo $row['s_user']; ?>)</td>
                            <td style="word-break:break-all;"><?php echo $row['s_content']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
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