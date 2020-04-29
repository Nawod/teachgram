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
	margin-right: 15px;
}


div[class="shape_receiver"]{
	background-color: white;
	padding: 7px 14px 7px 14px;
	border-radius: 0px 20px 20px 20px;
}

div[class="shape_sender"]{
	background-color: rgba(69, 162, 255, 0.93);
	padding: 7px 14px 7px 14px;
	border-radius: 20px 3px 20px 20px;
}

span[class="original_sender"]{
	color: white;
	display: inline-block;
	text-align: center;
}

span[class="original_receiver"]{
	color: gray;
	display: inline-block;
	text-align: center;
}
#last_activity{
	font-size:5%;
	text-align:left;
	position:absolute;
}
.d_img{
	position:sticky;
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
$selectedID = $_SESSION['rec_user_id'];
$user_id = $_SESSION['user_id'];
$rsa_p = $_SESSION['rsa_p'];//key for private key

$sent_msg_id = 0;//for naming msg ids

//get messeges from db
$chat_log_query = "SELECT * FROM chat_message ORDER BY chat_message_id ASC";
$executing_chat_log_query = mysqli_query($con,$chat_log_query);
$rows = mysqli_fetch_array($executing_chat_log_query);

//display messages
while($rows = mysqli_fetch_array($executing_chat_log_query))  :
	//check sender message
	if($rows["recv_id"] == $selectedID && $rows["sender_id"] == $user_id){
		$enc_sent_msg = $rows["sent_msg"];
		$sent_msg_id++;
		echo "<div class='sender'><span class='original_sender'><div class='shape_sender' id ='mi$sent_msg_id'></div></span></div>";
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
	else if($rows["sender_id"] == $selectedID && $rows["recv_id"] == $user_id){
		$enc_recv_msg = $rows["recv_msg"];
		$sent_msg_id++;
		echo "<div class='receiver'><span class='original_receiver'><div class='shape_receiver' id ='mi$sent_msg_id'></div></span></div>";
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

?>
