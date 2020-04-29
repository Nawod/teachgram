 <head>
  <style type="text/css">
  .my_profile_image{
      border-radius: 100%;
      cursor : pointer;
  }

  .user_nm{
    font-weight:bold;
    margin-left:15px;
  }

  .users_status_active{
    float:right;
    width: 10px;
    height: 10px;
    background-color: #16da16;
    border-radius: 50%;
    margin-right: 25px;
    margin-top: 13px;
    border: 2px solid rgba(0, 0, 0, 0.26);

  }

  .users_status_not_active{
    float:right;
    width: 10px;
    height: 10px;
    background-color: gray;
    border-radius: 50%;
    margin-right: 25px;
    margin-top: 13px;
    border: 2px solid rgba(0, 0, 0, 0.26);


  }
  .users:hover{
    cursor: pointer;
  }
  .users:hover > .my_profile_image{
    width:40px;
    height:40px;
    box-shadow:0px 6px 7px -1px #2c2c30;
  }
  .users:hover > .user_nm{
    text-shadow:0px 4px 4px #8e8f92;
  }
  </style>
 </head>

 <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>

<?php
session_start();
$user_id = $_SESSION['user_id'];
#connect db
include('../../db_con.php');

$command_query = "SELECT COUNT(*) AS total FROM login_details";

$execute_command_query = mysqli_query($con,$command_query)or die(mysqli_error($con));

$total_Users_Number = mysqli_fetch_assoc($execute_command_query);

echo "</br>";
//active user

  $query_1 = "SELECT * FROM login_details WHERE is_type = 'yes' ORDER BY last_activity DESC";
  $run = mysqli_query($con,$query_1)or die(mysqli_error($con));
  $userID = 0;
  while($row = mysqli_fetch_array($run)){
  	$userID++;
    $newuserID = $row["user_id"];
    echo "</br>";
    echo "<div>";


    $command_query = "SELECT * FROM login WHERE user_id = '$newuserID'";

    $execute_command_query = mysqli_query($con,$command_query);

    while($row = mysqli_fetch_assoc($execute_command_query)){
      if($newuserID != $user_id){
        $newuser_name = $row["first_name"];
        $newuser_email = $row["email"];
        if($row["Profile_Picture"]==""){
          echo "<div class='users' id='$newuserID' name='$newuser_name' alt='$newuser_email'><img class='my_profile_image' src='../profile_picture/default.png' height='35' width='35'title='$newuser_email'/>&nbsp;&nbsp;"."<p class='user_nm'>".$newuser_name."</p><span class='users_status_active'></span></div>";
        }else{
          $username_picture = $row["Profile_Picture"];
          echo "<div class='users' id='$newuserID' name='$newuser_name' alt='$newuser_email'><img class='my_profile_image' src='../profile_picture/$username_picture' height='35' width='35'title='$newuser_email'/>&nbsp;&nbsp;"."<p class='user_nm'>".$newuser_name."</p><span class='users_status_active'></span></div>";
        }
      }
  }
    echo "</div>";
  }
  echo "</br>";
  //inactive users

  $query_2 = "SELECT * FROM login_details WHERE is_type = 'no' ORDER BY last_activity DESC";
  $run = mysqli_query($con,$query_2)or die(mysqli_error($con));

  while($row = mysqli_fetch_array($run)){
    $userID++;
    $newuserID = $row["user_id"];

    echo "<div>";

 

    $command_query = "SELECT * FROM login WHERE user_id = '$newuserID'";
    $execute_command_query = mysqli_query($con,$command_query);

    while($row = mysqli_fetch_assoc($execute_command_query)){
      $newuser_name = $row["first_name"];
      $newuser_email = $row["email"];
      if($newuserID != $user_id){
        if($row["Profile_Picture"]==""){
          echo "<div class='users' id='$newuserID' name='$newuser_name' alt='$newuser_email'><img class='my_profile_image' src='../profile_picture/default.png' height='35' width='35'title='$newuser_email'/>&nbsp;&nbsp;"."<p class='user_nm'>".$newuser_name."</p><span class='users_status_not_active'></span></div></br>";
        }else{
        $username_picture = $row["Profile_Picture"];
          echo "<div class='users' id='$newuserID' name='$newuser_name' alt='$newuser_email'><img class='my_profile_image' src='../profile_picture/$username_picture' height='35' width='35'title='$newuser_email'/>&nbsp;&nbsp;"."<p class='user_nm'>".$newuser_name."</p><span class='users_status_not_active'></span></span></div></br>";
        
        }
      }
      
    }
    echo "</div>";
  }

 ?>

<script type="text/javascript">
$(document).ready(function(){
$(".users").click(function(){
var idvalue = $(this).attr('id');
	$(function(){
    $.ajax({
      type: "POST",
      url: 'set_user_id.php',
      data: ({userID:idvalue}),
      success: function(data) {
      
      }
    });
  });

});
});
</script>
