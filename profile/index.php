<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
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
    <a style="color: #000;text-align:center;" href="../users/index.php"><h1 style="font-weight:100;margin-bottom:20px;">AnonMessaging</h1></a>
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
            <h1><?php echo $row['user_name']; ?></h1>
            <p><?php echo $row['user_email']; ?></p>
            <?php
        }
    }
    ?>
    </div>
</body>
</html>