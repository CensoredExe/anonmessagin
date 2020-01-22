<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("../login");
    }
    include_once "../includes/connection.php";
    include_once "../includes/functions.php";
    if(!isset($_GET['search'])){
        echo "<script>window.location = 'index.php'</script>";
        exit();
    }
    $searchlog = htmlspecialchars(mysqli_real_escape_string($conn, $_GET['search']));
    addLog($_SESSION['user_email']." (".$_SESSION['user_id'].") searched for a user with query: ".$searchlog);
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
    <h1>See a list of users, or search for them.</h1>
        <form method="GET" action="search.php">
            <input class="search-bar" type="search" name="search" placeholder="Search for username or email" required>
        </form>
        <br><hr><br>
        
        <?php
           if(isset($_GET['search'])){
               $search = mysqli_real_escape_string($conn, $_GET['search']);
               addPoints($_SESSION['user_id'], 1);
               if(strlen($search) < 3){
                   echo "Search is too small.";
                   exit();
               }
               $sql = "SELECT * FROM `users` WHERE `user_name` LIKE '%$search%' OR `user_email` LIKE '%$search%' LIMIT 50";
               $result = mysqli_query($conn, $sql);
               if(mysqli_num_rows($result) == 0){
                   echo "0 Results for that search.";
                   exit();
               }
               while($row = mysqli_fetch_assoc($result)){
                ?>
                <a style="color: #000;" href="../profile/index.php?id=<?php echo $row['user_id']; ?>">
                <div class="user_div">
                    <h3><?php echo $row['user_name']; ?></h3>
                    <p style="margin-top:10px;"><?php echo $row['user_email']; ?></p>  
                </div>
                </a>
                <?php
            }
           }else {
               echo "No search specified";
           }
        ?>
    </div>
</body>
</html>