<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    if(!isset($_GET['id'])){
        echo "<script>window.location = '../index.php'</script>";
        exit();
    }
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM `gc_table` WHERE `g_id`='$id'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $name = $row['g_name'];
    }
    $user_id = $_SESSION['user_id'];
    checkBan($_SESSION['user_id']);
    if(falseMembership($user_id, $id)){
        echo "No membership to this groupchat";
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
    <a style="color: #000;text-align:center;" href="../"><h1 style="font-weight:100;margin-bottom:20px;">AnonMessaging</h1></a>
        <h1 style="font-weight:300;">Groupchat: <?php echo $name; ?></h1>
        <p><a href="members.php?id=<?php echo $id; ?>">View and add members</a></p>
        <br><hr><br>
        <form method="POST">
            <textarea name="msg_content" class="msg_textarea" required placeholder="Enter your message"></textarea>
            <button type="submit" name="submit" class="form-submit">Send</button>
        </form>
        <?php
        if(isset($_POST['submit'])){
            $content = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['msg_content']));
            if(empty($content)){
                echo "Error, message is empty.";
                exit();
            }
            date_default_timezone_set("Europe/London");
            $date = date("H:i:s d/m/Y");
            $sql = "INSERT INTO `gc_messages` (`msg_conv`,`msg_author` , `msg_content`, `msg_date`) VALUES ('$id', '$user_id', '$content', '$date')";
            if(mysqli_query($conn, $sql)){
                $url = "index.php?id='$id'";
                addPoints($_SESSION['user_id'], 2);
                echo "<script>window.location= window.location</script>";
                
                
            
            }else {
                echo "Error.";
            }
        }
        
        $sql = "SELECT * FROM `gc_messages` WHERE `msg_conv`='$id' ORDER BY `msg_id` DESC";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0){
            echo "No messages in this conversation, send one.";
            
        }else {
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