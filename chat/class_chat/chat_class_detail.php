
<?php
#connect db
include('../../db_con.php');
session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
//set variables
$selectedClzID = '';
if(isset($_SESSION['clz_id'])){
$selectedClzID = $_SESSION['clz_id'];
$user_id = $_SESSION['user_id'];
}
if($selectedClzID != ""){
//get clz details
$chat_log_query = "SELECT * FROM class_details WHERE class_id = $selectedClzID";
$executing_chat_log_query = mysqli_query($con,$chat_log_query);
$rows = mysqli_fetch_array($executing_chat_log_query);

	$class_name = $rows["class_name"];
	
		if($rows["class_dp"]==""){
	  		echo "<div class='d_img'><img class='user_dp' src='../class_dp/default.png' height='35' width='35'title='$class_name'/>&nbsp;"."<p class='d_name'>".$class_name."</p></div></hr>";
		}else{
		$class_picture = $rows["class_dp"];
		  echo "<div class='d_img'><img class='user_dp' src='../class_dp/$class_picture' height='35' width='35'title='$class_name'/>&nbsp;"."<p class='d_name'>".$class_name."</p></div></hr>";
		}
	
}
?>