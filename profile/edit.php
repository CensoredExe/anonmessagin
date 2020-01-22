<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    checkBan($_SESSION['user_id']);
    addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") opened edit page for their profile");
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
    <a style="color: #000;text-align:center;" href="index.php?id=<?php echo $_SESSION['user_id']; ?>"><h1 class="btn-title" style="font-weight:100;margin-bottom:20px;">AnonMessaging</h1></a><hr><br>
    <div class="edit-form">
        <?php
        $userpoints = checkPoints($_SESSION['user_id']);
        if($userpoints < 30){
            ?>
            <h2>Unforuntately, you cant edit your profile until you have 30 points.</h2>
            <?php
        }else {
            ?>
            <h2 style="font-weight:300;">Edit your account!</h2>
            <p>Currently you can only change your profile bio, PM an admin to request a change on other aspects of your account.</p><br><hr><br>
            <form method="POST">
                <label for="user_bio" style="font-size:24px;">User bio</label><br>
                <textarea style="font-size:20px;width:100%;border:2px solid blue;resize:none;" name="user_bio" id="user_bio" required placeholder="Enter a bio"><?php echo $_SESSION['user_bio']; ?></textarea><br>
                <button type="submit" name="submit" class="submit-btn">Update</button>
            </form>
            <?php
            if(isset($_POST['submit'])){
                $content = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_bio']));
                if(empty($content)){
                    echo "Fields must not be empty!";
                }else {
                    $uid = $_SESSION['user_id'];
                    $sql = "UPDATE `users` SET `user_bio`='$content' WHERE `user_id`='$uid'";
                    if(mysqli_query($conn, $sql)){
                        addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") edited their profile bio to: ".$content);
                        $_SESSION['user_bio'] = $content;
                        echo "<script>window.location = 'index.php?id=".$uid."'</script>";
                    }else {
                        echo "SQL Error";
                    }
                }
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