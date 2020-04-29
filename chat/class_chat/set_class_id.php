<?php
#connect db
include('../../db_con.php');
session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
//retrive data sent 
$selectedClzID = $_POST['classID'];
$selectedClzID = mysqli_real_escape_string($con,$selectedClzID);


//set session for reciver


if($selectedClzID != ""){
    $_SESSION['clz_id'] = $selectedClzID;
    include 'class_chat.php';
    include 'Chat_Log.php';
    include 'chat_class_detail.php';
}


?>