<?php declare(strict_types=1);

include('../../db_con.php');

session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}

$user_id = $_SESSION['user_id'];
$recv_pbk = '';
$txtmsg = '';
//get public keys
$sender_pbk = $_SESSION['public_k'];
if(isset($_SESSION['r_user_id'])){
    $rec_user_id = $_SESSION['r_user_id'];
    $get_recv_pbk = "SELECT public_key FROM login WHERE user_id = '$rec_user_id'";
    $excute_get_recv_pbk = mysqli_query($con,$get_recv_pbk);
    $run_get_recv = mysqli_fetch_assoc($excute_get_recv_pbk);
    $recv_pbk = $run_get_recv["public_key"];
}

if(isset($_POST["send_message"])){
  
  if($recv_pbk == '' || $_POST["sent_msg"] == 'undefined'|| $_POST["recv_msg"] == 'undefined'){
    $txtmsg = $_POST["txtmessage"];
    //get receiver publick key
    $get_recv_pbk = "SELECT public_key FROM login WHERE user_id = '$rec_user_id'";
    $excute_get_recv_pbk = mysqli_query($con,$get_recv_pbk);
    $run_get_recv = mysqli_fetch_assoc($excute_get_recv_pbk);
    $recv_pbk = $run_get_recv["public_key"];
    echo "<script>alert('Something went wrong!Send Again');</script>";
    echo "<script>window.location = '';</script>";
  }
else{
//send message
    if(!empty($_POST["sent_msg"]) && !empty($_POST["recv_msg"])){
      $sent_msg = $_POST["sent_msg"];
      $recv_msg = $_POST["recv_msg"];
//call xss clean function
      $sent_msg = xss_clean($sent_msg);
      $recv_msg = xss_clean($recv_msg);
//insert data
      $query = "INSERT INTO chat_message ( `recv_id`, `sender_id`, `sent_msg`, `recv_msg`, `status` ) VALUES ('$rec_user_id','$user_id' ,'$sent_msg','$recv_msg', '' )";
      if($run = mysqli_query($con,$query)){
        echo "<embed loop='false' src='Notification.wav' autoplay='true' hidden='true'/>";
      }
    } else{
    echo "<script>alert('Opps! Message is not sent');</script>";
    }
  }
  }

//mitigating xss attcak 
//source - https://gist.github.com/fredacx/4278809
  function xss_clean($data)
  {
    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {
          // Remove really unwanted tags
          $old_data = $data;
          $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);

    // we are done...
    return $data;
  }
?>

<!doctype html>
<html lang="en">
<head>  
    <title>TEACHGRAM</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <link href="../../css/private_chat.css" rel="stylesheet">
<!--encryption api-->
        <script language="JavaScript" type="text/javascript" src="../../api/jsbn.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/random.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/hash.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/rsa.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/aes.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../api/api.js"></script>


</head> 
<body>
<!--header-->
    <div class="container-fluid header">
                <p>TEACHGRAM</p>
    </div>
<!--main container-->
    <div class="container dashboard">
        <div class="row">
<!--left side dashboard-->
            <div class="col-4 left-dash">
                    <div class="row">
                        <div class="col user-details">
                            <?php include "../dp/get_dp.php" ?>
                            <button type="button" name="logout" class="btnLogout" onclick="window.location.href = '../../logout.php';">Logout</button><br/>
                        </div>
                    </div>
                <div class="row">
                    <div class="col add-friends">
                        <img src="../img/add_new.png" alt=""/>
                        <br>
                        <br>
                        <hr/>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col chat-details">
                    <div id="Get_Online_Users" >

                    </div >
                    </div>
                </div>
            </div>
<!--right side container-->
            <div class="col private-chat">
<!--navigation bar-->
                  <div class="row navi-row">
                    <a href="../class_chat/class_chat.php" class = "navi"><div class="col">
                        <p>Class Chat</p>
                    </div></a>
                    <div class="col navi-active">
                      <p>Friends Chat</p>                      
                    </div> 
                    <a href="../create_class/create_class.php" class = "navi" id = "create_clz"><div class="col">
                        <p>Create Class</p>
                    </div></a>
                    <a href="#" class = "navi"><div class="col">
                        <p>Profile</p>
                    </div></a>
                  </div>
<!--chat header-->
                <div class="row">
                    <div class="col">
                        <div id="chat_header">
                            <div id="get_chat_header">
                              
                            </div>
                        </div>
                    </div>
                </div>           
<!--main chat-->
                <div class="row">
                    <div class="col">
                        <div id="Main_Chat_Box">
                            <div id="get_chat_logs">

                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col" id = "txtarea">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form_send_message">
                        <textarea id="text_area" placeholder="Type Something Here" name="txtmessage" value="<?php echo $txtmsg ?>"></textarea><img src="../img/send.png" alt="Send Image" id="send_button"/>
                        <input type="hidden" name="sent_msg" id = "sent_msg" value="" />
                        <input type="hidden" name="recv_msg" id="recv_msg" value=""/>
                        <input type="submit" name="send_message" value="" id="btn_Send" onclick="encrypt_message();" />
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

<script type="text/javascript">

  $(document).ready(function(){
    var user_type = "<?php echo $_SESSION['user_type']; ?>";
    if(user_type == 'Student'){
      document.getElementById("create_clz").style.display = "none";
    }
    var tmppbk = "<?php echo $recv_pbk; ?>";
    var tmppbk2 = "<?php echo $sender_pbk; ?>";
    
    if(tmppbk == tmppbk2){
      document.getElementById("text_area").disabled = true;
    }
//get online users
    $.ajax({
      cache:true,
      success:function(status){
      setInterval(function(){
      $("#Get_Online_Users").load("Online_Users.php"); // Add s to the #Get_Online_User to start ajax requests
    },500);
    }
    });
//get messages
    $.ajax({
      cache:true,
      success:function(status){
      setInterval(function(){
        $("#get_chat_logs").load("Chat_Log.php");    // Add x to the #Main_Chat_Bo to start ajax requests
      },300);
    }
    });
//load chat header
    setInterval(function(){
      $("#get_chat_header").load("chat_user_detail.php");    
    },300);
  
//load profile picture
$("#my_profile_picture").load("../dp/get_profile_pic.php");
//update profile picture
    $("#my_profile_picture").click(function(){
    $('#file').trigger("click");
    });
    $("#file").change(function(){
    $("#submit_file").trigger("click");
    });

    $("#submit_file").click(function(){
      $(this).submit();
    });

    $("#submit_file").submit(function(){
    $("#my_profile_picture").load("../dp/get_profile_pic.php");
    });

//message sending
  $("#send_button").hover(function() {

  $(this).attr("src","../img/send2.png");
      }, function(){

  $(this).attr("src","../img/send.png");
  });

  $("#send_button").click(function(){
    $("#btn_Send").trigger("click");
  });

  $("#btn_Send").click(function(){
    $(this).submit();
  });

});
</script>
<script>
//encrypt messages by sender and receiver public keys
function encrypt_message(){
        var PlainText = document.getElementById("text_area").value;
        var recv_pbk = "<?php echo $recv_pbk; ?>";
        var sender_pbk = "<?php echo $sender_pbk; ?>";
        var sent_msg = cryptico.encrypt(PlainText, sender_pbk);
        var recv_msg = cryptico.encrypt(PlainText, recv_pbk);
        
        document.getElementById("sent_msg").value = sent_msg.cipher;
        document.getElementById("recv_msg").value = recv_msg.cipher;
      
     }

</script>
</html>