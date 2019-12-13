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
        <div class="introduction">
            <h1 style="font-weight:300;font-size:50px;">AnonDashboard</h1>
            <p>See new messages or start a conversation.</p>
            <p>Welcome back, <?php echo $_SESSION['user_name']; ?></p>
            <p>AnonScore: <?php echo checkPoints($_SESSION['user_id']); ?></p><br>
            <hr><br>
            
            <?php
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM `conversations` WHERE `conv_sender`='$id' OR `conv_recipient`='$id' ORDER BY `conv_id` DESC";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) == 0){
                    // No conversations open
                    ?>
                    <h2 style="font-weight:300;">You currently have no messages open, start one.</h2><br>
                    <a href="../users/index.php">Search for users</a>
                    <?php
                }else {
                    ?>
                    <h2 style="font-weight:300;">Open conversations:</h2><br>
                    <?php
                    while($row = mysqli_fetch_assoc($result)){
                        if($row['conv_sender'] == $_SESSION['user_id']){
                            $name = $row['conv_recipient'];
                        }else {
                            $name = $row['conv_sender'];
                        }
                        
                        ?>
                        <a style="color:#000;" href="../chat/index.php?id=<?php echo $row['conv_id']; ?>">
                        <div class="conversation">
                            <h2 style="font-weight:300;"><?php echo findName($name); ?></h2>
                            <p><?php echo findEmail($name); ?></p>
                        </div>
                        </a>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="right-column">
            <h2 style="font-weight:300;">Actions</h2>
            <hr>
            <ul>
                <li><a href="../logout">Logout</a></li>
                <li><a href="../users/index.php">Users</a></li>
            </ul>
        </div>
    </div>
</body>
</html>