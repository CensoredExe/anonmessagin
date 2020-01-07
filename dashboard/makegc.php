<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    checkBan($_SESSION['user_id']);
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
            <p>AnonScore: <?php echo checkPoints($_SESSION['user_id']); ?></p>
            <br>
            <hr><br>
            <form method="POST">
                <input type="text" name="gc_name" id="gc_name" placeholder="GroupChat title" style="width:100%;border:2px solid green;padding:8px;font-size:22px;border-radius:4px;">
                <button class="submit-btn" name="submit">Create group</button>
            </form>
            <?php
            if(isset($_POST['submit'])){
                $gc_title = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['gc_name']));
                $sql1 = "INSERT INTO `gc_table` (`g_name`) VALUES ('$gc_title')";
                if(mysqli_query($conn, $sql1)){
                    // GC Created
                    $user_id = $_SESSION['user_id'];
                    $sql3 = "SELECT * FROM `gc_table` WHERE `g_name`='$gc_title' ORDER BY `g_id` DESC LIMIT 1";
                    $result = mysqli_query($conn, $sql3);
                    while($row = mysqli_fetch_assoc($result)){
                        $g_id = $row['g_id'];
                    }
                    $sql2 = "INSERT INTO `gc_members` (`g_gc`, `g_user`) VALUES ('$g_id', '$user_id')";
                    if(mysqli_query($conn, $sql2)){
                        echo "<script>window.location='index.php'</script>";
                        exit();
                    }else {
                        echo "GC Creation ER 2 - Report to staff";
                    }
                }else {
                    // Error
                    echo "GC Creation ER 1 - Report to staff";
                }
            }
            ?>
            <p>* You can add members once the group is created.</p>
            
           
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