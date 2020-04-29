<?php
#connect db
include('../../db_con.php');
session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
$user_id = $_SESSION['user_id'];
  $command_query = "SELECT * FROM login WHERE user_id = '$user_id'";

  $execute_command_query = mysqli_query($con,$command_query);

  while($row = mysqli_fetch_assoc($execute_command_query)){

    if($row["Profile_Picture"]==""){
        echo "<img class='my_profile_pic' src='../profile_picture/default.png' title='Click to change profile picture'/>";
    }else{
        $picture_holder = $row["Profile_Picture"];
        echo "<img class='my_profile_pic' src='../profile_picture/$picture_holder' title='Click to change profile picture'/>";
    }
  }

  mysqli_close($con);


?>
