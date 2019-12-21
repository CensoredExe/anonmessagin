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
    <a style="color: #000;text-align:center;" href="../"><h1 style="font-weight:100;margin-bottom:20px;">AnonMessaging</h1></a>
        <h1 style="font-weight:300;">Global Group Chat</h1>
        <p>Every user on the site has access to this</p>
        
        <br><hr><br>
        <form method="POST">
            <textarea name="msg_content" class="msg_textarea" required placeholder="Enter your message"></textarea>
            <button type="submit" name="submit" class="form-submit">Send</button>
        </form>
        <?php
        if(isset($_POST['submit'])){
            $msg_content = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['msg_content']));
            if(empty($msg_content)){
                echo "Error, empty message.";
                exit();
            }
            date_default_timezone_set("Europe/London");
            $date = date("H:i:s d/m/Y");
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO `global` (`msg_content`, `msg_author`, `msg_date`) VALUES ('$msg_content', '$user_id', '$date')";
            if(mysqli_query($conn, $sql)){
                addPoints($_SESSION['user_id'], 2);
                echo "<script>window.location=window.location</script>";
            }else {
                echo "DB error";
            }
        }
        ?><br>
        <button class="check-btn" onclick="window.location=window.location">Check for new messages</button>
        <style>
            .check-btn:hover {
                cursor: pointer;
            }
        </style>
       <!-- Messages -->
       <?php
        $sql = "SELECT * FROM `global` ORDER BY `msg_id` DESC LIMIT 150";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            ?>
    <div class="message">
            <div class="msg-info">
            <a style="color:#000;" href="../profile/index.php?id=<?php echo $row['msg_author']; ?>"><h3 style="font-weight:300;"><?php echo findName($row['msg_author']); ?></h3></a>
            <p><?php echo $row['msg_date']; ?></p>
            <p>User Points: <?php echo checkPoints($row['msg_author']); ?></p>  
            </div>
            
            <div class="msg-content"?>
            <?php echo $row['msg_content']; ?>
            </div>
        </div>
            <?php
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