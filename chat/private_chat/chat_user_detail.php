<style>
.user_dp{
	border-radius:100%;
}
</style>
<?php
#connect db
include('../../db_con.php');
session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
//set variables
$selectedID = $_SESSION['rec_user_id'];
$user_id = $_SESSION['user_id'];
$_SESSION['r_user_id'] = $selectedID;
//get user last activity
$chat_log_query = "SELECT * FROM login_details WHERE user_id = $selectedID";
$executing_chat_log_query = mysqli_query($con,$chat_log_query);
$rows = mysqli_fetch_array($executing_chat_log_query);

//display user details
$get_user_d  = "SELECT * FROM login WHERE user_id = '$selectedID'";
$execute_get_user_d =  mysqli_query($con,$get_user_d);
$user_d = mysqli_fetch_array($execute_get_user_d);
	$d_name = $user_d["first_name"];
	$d_email = $user_d["email"];
	$d_lastactivity = $rows["last_activity"];

	if($selectedID != $user_id){
		if($user_d["Profile_Picture"]==""){
	  		echo "<div class='d_img'><img class='user_dp' src='../profile_picture/default.png' height='35' width='35'title='$d_email'/>&nbsp;"."<p class='d_name'>".$d_name."</p><p class='last_activity'>&nbsp;&nbsp;Last activity&nbsp;-&nbsp;".$d_lastactivity."</p></div></hr>";
		}else{
		$username_picture = $user_d["Profile_Picture"];
		  echo "<div class='d_img'><img class='user_dp' src='../profile_picture/$username_picture' height='35' width='35'title='$d_email'/>&nbsp;"."<p class='d_name'>".$d_name."</p><p class='last_activity'>&nbsp;&nbsp;Last activity&nbsp;-&nbsp;".$d_lastactivity."</p></div></hr>";
		}
	}

?>