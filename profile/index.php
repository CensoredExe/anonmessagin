<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: ../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    checkBan($_SESSION['user_id']);
    $idlog = mysqli_real_escape_string($conn, $_GET['id']);
    addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") opened profile page for ID: ".$idlog);
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
    <a style="color: #000;text-align:center;" href="../users/index.php"><h1 class="btn-title" style="font-weight:100;margin-bottom:20px;">AnonMessaging</h1></a><hr><br>
    <?php 
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM `users` WHERE `user_id`='$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0){
        echo "Error, account doesnt exist.";
        exit();
    }else {
        while($row = mysqli_fetch_assoc($result)){
            ?>
            <center>
            <?php
            if($row['user_type'] == 'admin'){
                ?>
                <p style="margin:none;margin-top:-10px;color:red;font-weight:700;">Admin Account</p>
                <?php
            }
            if($row['user_id'] == $_SESSION['user_id']){
                ?>
                <a href="edit.php">Edit profile</a>
                <?php
                
            }
            if($_SESSION['user_type'] == 'admin'){
                ?>
                <a style="color:red;font-weight:700;" href="ban.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure?');">BAN</a>
                <?php
            }
            ?>
            <h1 class="user_name" style="font-weight:300;"><?php echo $row['user_name']; ?></h1>
            <p class="user_email"><?php echo $row['user_email']; ?></p>
            <br>
            
            <br>
            <p><?php echo $row['user_bio']; ?></p>
            <br><hr><br>
            <h3>User Points: <?php echo checkPoints($row['user_id']); ?></h3>
            <br><hr><br>
            <p>Click the message button to begin a conversation with this user!</p>
            <a class="addConv" href="startconversation.php?sender=<?php echo $_SESSION['user_id'] ?>&recipient=<?php echo $row['user_id']; ?>">Message</a>
            </center>
            <?php
        }
    }
    ?>
    <br><hr><br>
    <div class="comment-form">
        <form method="POST">
            <textarea style="width: 100%;max-width:100%;min-width:100%;font-size:22px;border:2px solid black;padding:10px;" class="comment-area" name="comment-area" placeholder="Comment on this user's profile."></textarea>
            <button type="submit" name="submit" class="submit-btn">Comment</button>
        </form>
        <?php
        date_default_timezone_set("Europe/London");
        // Add comments to DB
        if(isset($_POST['submit'])){
            $comment_content = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['comment-area']));
            $date = date("H:i:s d/m/Y");
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO `comments` (`comment_profile`, `comment_user`, `comment_content`, `comment_date`) VALUES ('$id', '$user_id', '$comment_content', '$date')";
            if(mysqli_query($conn, $sql)){
                addPoints($user_id, 5);
                addPoints($id, 3);
                addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") commented on user's profile. user uid: ".$id);
                echo "<script>window.location = window.location</script>";
            }else {
                ?>
                ERROR
                <?php
            }
        }
        ?>
    </div>
    <br>
    <?php
    // Select comments from DB
    $sql = "SELECT * FROM `comments` WHERE `comment_profile`='$id' ORDER BY `comment_id` DESC LIMIT 100";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        ?>
 <div class="comment">
        <div class="comment-info">
            <a style="color:#000;text-decoration:none;" href="index.php?id=<?php echo $row['comment_user']; ?>"><h3><?php echo findName($row['comment_user']); ?></h3></a>
            <p><?php echo $row['comment_date']; ?></p>
            <p>Points: <?php echo checkPoints($row['comment_user']); ?></p>
        </div>
        <div class="comment-content">
            <p><?php echo $row['comment_content']; ?></p>
        </div>
    </div>
        <?php
    }
    ?>
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