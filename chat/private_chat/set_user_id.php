<?php
#connect db
include('../../db_con.php');
session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
//retrive data sent 
$selectedID = $_POST['userID'];
$selectedID = mysqli_real_escape_string($con,$selectedID);
//get receiver publick key
$get_recv_pbk = "SELECT public_key FROM login WHERE user_id = '$selectedID'";
$excute_get_recv_pbk = mysqli_query($con,$get_recv_pbk);
$run_get_recv = mysqli_fetch_assoc($excute_get_recv_pbk);
$recv_pbk = $run_get_recv["public_key"];
//set session for reciver

$_SESSION['r_user_id'] = $selectedID;
$_SESSION['rec_public_key'] = $recv_pbk;
$_SESSION['rec_user_id'] = $selectedID;
if($selectedID != ""){
    
    include 'Chat_Log.php';
    include 'chat_user_detail.php';
    include 'private_chat.php';
    header("Location: private_chat.php");
    echo "<script>window.location = 'private_chat.php';</script>";
}


?>
