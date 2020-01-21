<?php
    include_once "connection.php";
    // Check Bans
    function checkBan($id){
        global $conn;
        $sql = "SELECT * FROM `users` WHERE `user_id`='$id'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0){
            
            session_unset();
            session_destroy();
            echo "<script>window.location = 'https://BANNED'</script>";
        }
        return;
    }
    // Check points
    function checkPoints($id){
        global $conn;
        $sql = "SELECT * FROM `users` WHERE `user_id`='$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $points = $row['user_points'];
        }
        if(mysqli_num_rows($result) == 0){
            // Account doesnt exist
            $points = "None";
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

    // Find username
    function findName($id){
        global $conn;
        $sql = "SELECT * FROM `users` WHERE `user_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0){
            $name = "User doesnt exist";
        }
        while($row = mysqli_fetch_assoc($result)){
            $name = $row['user_name'];
        }
        return $name;
    }
    
    // Find email
    function findEmail($id){
        global $conn;
        $sql = "SELECT * FROM `users` WHERE `user_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0){
            $email = "Error";
        }
        while($row = mysqli_fetch_assoc($result)){
            $email = $row['user_email'];
        }
        return $email;
    }
    // Add unread message
    function addUnread($id, $conv_id, $msg){
        global $conn;
        $sql = "INSERT INTO `unread` (`read_conv`, `read_user`, `read_msg`) VALUES ('$conv_id', '$id', '$msg')";
        mysqli_query($conn, $sql);
    }
    // Delete conv + Messages associated
    function deleteConv($id){
        global $conn;
        $sql1 = "DELETE FROM `conversations` WHERE `conv_id`='$id'";
        $sql2 = "SELECT FROM `messages` WHERE `msg_conv`='$id'";
        mysqli_query($conn, $sql1);
        mysqli_query($conn, $sql2);
        return;
    }
    // Check membership for a groupchat, return True if false membership
    function falseMembership($user_id, $gc_id){
        global $conn;
        $sql = "SELECT * FROM `gc_members` WHERE `g_gc`='$gc_id'"; 
        $result = mysqli_query($conn, $sql);
        $membership = True;
        while($row = mysqli_fetch_assoc($result)){
            if($user_id == $row['g_user']){
                $membership = False;
            }
        }
        return $membership;
    }

    function getID($email){
        global $conn;
        $sql = "SELECT * FROM `users` WHERE `user_email` = '$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0){
            return 0;
        }
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['user_id'];
        }
        return $id;
    }

    // Add a log
    function addLog($content){
        global $conn;
        $content = htmlspecialchars(mysqli_real_escape_string($content));
        $sql = "INSERT INTO `logs` (`log_data`) VALUES ('$content')";
        mysqli_query($conn, $sql);
    }
?>