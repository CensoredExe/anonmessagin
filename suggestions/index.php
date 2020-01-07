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
            <h1 style="font-weight:300;font-size:50px;">AnonSuggestions</h1>
            <p>See new messages or start a conversation.</p>
            <p>Welcome back, <?php echo $_SESSION['user_name']; ?></p>
            <p>AnonScore: <?php echo checkPoints($_SESSION['user_id']); ?></p>
            <br>
            <hr>
            <br>
            <h3>Here, you can make private suggestions on how we can improve the site.</h3><br>
            <form method="POST">
                <textarea name="suggestion" style="width:100%;max-width:100%;min-width:100%;font-size:22px;border:2px solid #000;padding:10px;" placeholder="How can we improve?" required></textarea>
                <button class="submit-btn" name="submit" type="submit">Submit</button>
            </form>
        <?php
        if(isset($_POST['submit'])){
            $suggestion = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['suggestion']));
            $user = $_SESSION['user_id'];
            date_default_timezone_set("Europe/London");
            $date = date("H:i:s d/m/Y");
            $sql = "INSERT INTO `suggestions` (`s_content`, `s_date`, `s_user`) VALUES ('$suggestion', '$date', '$user')";
            if(mysqli_query($conn, $sql)){
                echo "<p>Suggestion sent, thanks for the feedback.</p>";
            }else {
                echo "Error, please message an admin you got this error";
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