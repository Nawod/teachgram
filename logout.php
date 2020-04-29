<?php

session_start();
$user_id = $_SESSION['user_id'];
#connect db
include('db_con.php');
//update user online status
    $update_status_command = "UPDATE login_details SET is_type = 'no' WHERE user_id ='$user_id'";
    $execute_status_command = mysqli_query($con, $update_status_command);
    
    // Unset all session values 
    $_SESSION = array();
session_destroy();

header('location:login.php');

?>
