<html>
<head>
		<script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>

<!--encryption api-->
		<script language="JavaScript" type="text/javascript" src="../../api/jsbn.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/random.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/hash.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/rsa.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/aes.js"></script>
		<script language="JavaScript" type="text/javascript" src="../../api/api.js"></script>
		
<style type="text/css">

.sender,.receiver{
	
	width: 70%;
	margin-top: 2px;
	margin-bottom: 2px;
}

.receiver{
	float: left;
	text-align: left;
	margin-left: 15px;
}

.sender{
	float:right;
	text-align: right;

}


div[class="shape_receiver"]{
	background-color: white;
	padding: 7px 14px 0px 14px;
	border-radius: 20px 20px 20px 0px;
}

div[class="shape_sender"]{
	background-color: rgba(69, 162, 255, 0.93);
	padding: 7px 14px 0px 14px;
	border-radius: 20px 20px 0px 20px;
}

span[class="original_sender"]{
	color: white;
	display: inline-block;
	text-align: right;
}

span[class="original_receiver"]{
	color: gray;
	display: inline-block;
	text-align: left;
}

.general_profile_sender{
	border-radius: 100%;
	position: relative;
	margin-left:0.3%;

}

.general_profile_receiver{
	border-radius: 100%;
	margin-right: 4px;
}
#title{
	font-size: 67%;
	text-align: left;
	margin-bottom:10%;
    margin-top: 20%;
}
.inside{
	padding-bottom:22%;
}
</style>

</head>
<body>

<body>
		
</html>
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
//get class details
$get_clz = "SELECT * FROM class_details WHERE class_id = $selectedClzID";
$excute_get_clz = mysqli_query($con,$get_clz);
$run_get_clz = mysqli_fetch_assoc($excute_get_clz);
$rsa_p  = $run_get_clz["enrollment_key"];
$class_name = $run_get_clz["class_name"];
$creater_id = $run_get_clz["creater_id"];
$sent_msg_id = 0;//for naming msg ids

//get messeges from db
$selected_class_table = $creater_id."_".$class_name."_msgs";
$selected_class_table = strtolower($selected_class_table);

$chat_log_query = "SELECT * FROM $selected_class_table ORDER BY msg_id ASC";
$executing_chat_log_query = mysqli_query($con,$chat_log_query);
//display messages
while($rows = mysqli_fetch_array($executing_chat_log_query))  :
//get user details
	$sender_id = $rows["sender_id"];
	$profile_pic_query = "SELECT * FROM login WHERE user_id = '$sender_id'";
	$execute_command_query = mysqli_query($con,$profile_pic_query);
	$get_profile = mysqli_fetch_assoc($execute_command_query);
	$sender_mail = $get_profile["email"];
	$sender_name = $get_profile["first_name"];
	//check sender message
	if($sender_id == $user_id){
		$enc_sent_msg = $rows["messages"];
		$sent_msg_id++;
		
		if($get_profile["Profile_Picture"]==""){
			echo "<div class='sender'><span class='original_sender'><div class='shape_sender' ><p id='title'>You :</p><p id ='mi$sent_msg_id' class='inside'></p></div></span><img class='general_profile_sender' src='../profile_picture/default.png' height='35' width='35' title='".$sender_name,'&nbsp - '.$sender_mail."'/></div>";
		 }else{
			 $username_picture = $get_profile["Profile_Picture"];
			 echo "<div class='sender'><span class='original_sender'><div class='shape_sender'><p id='title'>You :</p><p id ='mi$sent_msg_id' class='inside'></p></div></span><img class='general_profile_sender' src='../profile_picture/$username_picture' height='35' width='35' title='".$sender_name,'&nbsp - '. $sender_mail."'/></div>";
		 }

		echo "<script>
			var enc_sent_msg = '$enc_sent_msg';
		
			var pass = '$rsa_p';
		   	var PassPhrase = pass;
		   	var Bits = 512;
	
		   	var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
			var sent_msg = cryptico.decrypt(enc_sent_msg, RSAkey);
		
			document.getElementById('mi$sent_msg_id').innerHTML = sent_msg.plaintext;
		
			</script>";
	}
	//check recever message
	else {
		$enc_recv_msg = $rows["messages"];
		$sent_msg_id++;
		
		if($get_profile["Profile_Picture"]==""){
			echo "<div class='receiver'><img class='general_profile_receiver' src='../profile_picture/default.png' height='35' width='35' title='".$sender_name,'&nbsp - '.$sender_mail."'/><span class='original_receiver'><div class='shape_receiver'><p id='title'>".$sender_name." :</p><p id ='mi$sent_msg_id' class='inside'></p></div></span></div>";
	 
		 }else{
			 $username_picture = $get_profile["Profile_Picture"];
			 echo "<div class='receiver'><img class='general_profile_receiver' src='../profile_picture/$username_picture' height='35' width='35' title='".$sender_name,'&nbsp - '.$sender_mail."'/><span class='original_receiver'><div class='shape_receiver'><p id='title'>".$sender_name." :</p><p id ='mi$sent_msg_id' class='inside'></p></div></span></div>";
		 }
		
		echo "<script>
			var enc_recv_msg = '$enc_recv_msg';
			var pass = '$rsa_p';
		   	var PassPhrase = pass;
		   	var Bits = 512;
	
		   	var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
			var recv_msg = cryptico.decrypt(enc_recv_msg, RSAkey);
			document.getElementById('mi$sent_msg_id').innerHTML = recv_msg.plaintext;
		</script>";
	}
endwhile;
}
?>
