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
        <h2 style="font-weight: 100;">Signup</h2>
        <label for="user_email">Email</label>
        <input type="email" name="user_email" id="user_email" placeholder="anon@messaging.com"  required>
        <label for="user_name">Name</label>
        <input type="text" name="user_name" id="user_name" placeholder="John Doe" required>
        <label for="user_password">Password</label>
        <input type="password" name="user_password" id="user_password" placeholder="***********" required>
        <label for="user_password_conf">Confirm password</label>
        <input type="password" name="user_password_conf" id="user_password_conf" placeholder="***********" required>
        <button type="submit" name="submit">Signup</button>
            <a href="../login/">Login</a>
            
        </form>
        <?php
        if(isset($_POST['submit'])){
            $user_email = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['user_email']));
            $user_name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_name']));
            $user_password = $_POST['user_password'];
            $user_password_conf = $_POST['user_password_conf'];
            if(empty($user_email) || empty($user_name) || empty($user_password) || empty($user_password_conf)){
                // Error, empty values
                echo "Error, empty values";
                exit();
            }
            if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
                echo "Error, invalid email";
                exit();
            }
            if($user_password_conf != $user_password){
                echo "Passwords dont match";
            }else {
                // Check if account exists
                $sql = "SELECT * FROM `users` WHERE `user_email` = '$user_email'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    //Account exists
                    echo "Error, account with this email already exists";
                    exit();
                }else {
                    $hash = password_hash($user_password, PASSWORD_DEFAULT);
                    // Account doesnt exist
                    $sql = "INSERT INTO `users` (`user_email`, `user_name`, `user_password`,`user_bio`, `user_pfp`, `user_type`) VALUES ('$user_email', '$user_name', '$hash', 'User hasnt entered a bio', 'uploads/default.png', 'user');";
                    if(mysqli_query($conn, $sql)){
                        echo "Account made";
                    }else {
                        echo "Error, account not made.";
                    }
                }
            }


        }
        ?>
   </div>
    
</body>
</html>