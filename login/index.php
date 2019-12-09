<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        // Already logged in
        header("Location: ../dashboard/");
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
   <div class="form-hold">
   <a style="color: #000;text-align:center;" href="../"><h1 style="font-weight:100;">AnonMessaging</h1></a>
        <form method="POST">
        <h2 style="font-weight: 100;">Login</h2>
            <label for="user_email">Email</label>
            <input type="email" name="user_email" id="user_email" placeholder="anon@anonmessaing.com" required>
            <label for="user_password">Password</label>
            <input type="password" name="user_password" id="user_password" placeholder="*****************" required>
            <button type="submit" name="submit">Login</button>
            <a href="../signup/">Signup</a>
        </form>
        <?php
            if(isset($_POST['submit'])){
                $user_email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_email']));
                $user_password = $_POST['user_password'];
                $sql = "SELECT * FROM `users` WHERE `user_email` = '$user_email';";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    // Account exists
                    while($row = mysqli_fetch_assoc($result)){
                        if(password_verify($user_password, $row['user_password'])){
                            // Passsword is correct, log them in
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['user_name'] = $row['user_name'];
                            $_SESSION['user_email'] = $row['user_email'];
                            $_SESSION['user_bio'] = $row ['user_bio'];
                            $_SESSION['user_type'] = $row['user_type'];
                            header("Location: ../dashboard/");
                        }else {
                            // Password is incorrect
                            echo "Error, password is incorrect";
                        }
                    }
                }else {
                    // Account doesnt exist
                    echo "Account doesnt exist, make one?";
                }
            }
        ?>
   </div>
    
</body>
</html>