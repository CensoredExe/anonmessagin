<?php
    include_once "connection.php";
    // Check Bans

    // Check points
    function checkPoints($id){
        global $conn;
        $sql = "SELECT * FROM `users` WHERE `user_id`='$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $points = $row['user_points'];
        }
        return $points;
    }

    // Add points
    function addPoints($id, $points){
        global $conn;

        $sql = "SELECT * FROM `users` WHERE `user_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $pointscurrent = $row['user_points'];
        }
        $points += $pointscurrent;

        $sql = "UPDATE `users` SET `user_points`='$points' WHERE `user_id`='$id'";
        if(mysqli_query($conn, $sql)){
            // Success, points added.
        }else {
            echo "Error";
        }
    }
?>