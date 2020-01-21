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
    $sql2 = "DELETE FROM `unread` WHERE `read_conv`='$id' AND `read_user`='$user_id'";
    mysqli_query($conn, $sql2);
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
        <br><hr><br>
        <h2>Members:</h2>
        <ul>
            <?php
            $sql = "SELECT * FROM `gc_members` WHERE `g_gc`='$id'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <p><a href="../profile/index.php?id=<?php echo $row['g_user']; ?>"><?php echo findName($row['g_user']); ?></a> | <a onclick="return confirm('Are you sure you wish to remove this person from the groupchat?');" href="remove_member.php?id=<?php echo $id; ?>&uid=<?php echo $row['g_user']; ?>">remove</a></p>
                <?php
            }
            ?>
        </ul>
        <br><hr><br>
        <h2>Add a user</h2>
        <p>To do this, enter their <i>email</i> and click enter.</p>
        <form method="post">
            <input type="text" name="add" id="add" placeholder="Enter an email" style="width:100%;border:2px solid green;padding:8px;font-size:22px;border-radius:4px;">
        </form>
        <?php
        if(isset($_POST['add'])){
            $email = mysqli_real_escape_string($conn, $_POST['add']);
            if(empty($email)){
                echo "Error, email field is empty.";
            }else {
                $sql = "SELECT * FROM `users` WHERE `user_email`='$email'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) == 0){
                    echo "User doesn't exists";
                    exit();
                }
                $uid = getID($email);
                
                $sql = "INSERT INTO `gc_members` (`g_gc`, `g_user`) VALUES ('$id', '$uid')";
                if(mysqli_query($conn, $sql)){
                    addPoints($user_id, 5);
                    echo "<script>window.location = window.location</script>";  
                }else {
                   echo "Error, please contact staff.";
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