<?php declare(strict_types=1);

include('../../db_con.php');

session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
$user_id = $_SESSION['user_id'];

//get enc keys
$clz_pbk = '';
$clz_name = '';
$cret_id = '';
$txtmsg = '';
if(isset($_SESSION['clz_id'])){
  $selectedClzID = $_SESSION['clz_id'];
  //get class details
  $get_clz = "SELECT * FROM class_details WHERE class_id = '$selectedClzID'";
  $excute_get_clz = mysqli_query($con,$get_clz);
  $run_get_clz = mysqli_fetch_assoc($excute_get_clz);
  
  $clz_pbk = $run_get_clz["class_pbk"];
  $clz_name = $run_get_clz["class_name"];
  $cret_id = $run_get_clz["creater_id"];
}

//send message
if(isset($_POST["send_message"])){
  $sent_msg = $_POST["sent_msg"];
  $txtmsg = $_POST["txtmessage"];
  if($clz_pbk == '' || $clz_name == '' || $sent_msg == 'undefined'){
    //get receiver publick key
    $get_clz = "SELECT * FROM class_details WHERE class_id = '$selectedClzID'";
    $excute_get_clz = mysqli_query($con,$get_clz);
    $run_get_clz = mysqli_fetch_assoc($excute_get_clz);
  
    $clz_pbk = $run_get_clz["class_pbk"];
    $clz_name = $run_get_clz["class_name"];
    $cret_id = $run_get_clz["creater_id"];
    
    echo "<script>alert('Something went wrong! Send again');</script>";
    echo "<script>window.location = 'class_chat.php';</script>";
  }
  else{
//send message
    if(!empty($_POST["sent_msg"])) {
      $sent_msg = $_POST["sent_msg"];
//call xss clean function
      $sent_msg = xss_clean($sent_msg);
//insert data
      $table_name = $cret_id."_".$clz_name."_msgs";
      $table_name = strtolower($table_name);
      $query = "INSERT INTO $table_name(`msg_id`, `sender_id`,`messages`, `time`) VALUES (NULL ,'$user_id' , '$sent_msg' , CURRENT_TIMESTAMP)";
      if($run = mysqli_query($con,$query)){
        echo "<embed loop='false' src='Notification.wav' autoplay='true' hidden='true'/>";
      }else{
        echo "<script>alert('Opps! Message is not sent');</script>";
      }

    }
    else{
      echo "<script>alert('Opps! Message is not sent');</script>";
    }
  }
}


//enroll new class
$err = '';
$class_name = '';

if (isset($_POST["submit"])) {
    $class_name = $_POST["class_name"];
    $en_key = $_POST["enkey"];
 //validate inputs against xss   
    $class_name = mysqli_real_escape_string($con, $class_name);
    $en_key = mysqli_real_escape_string($con, $en_key);

    $class_name = xss_clean($class_name);
    $en_key = xss_clean($en_key);

#check the class exist
    $get_class_details = "SELECT * FROM class_details WHERE class_name = '$class_name' AND enrollment_key = '$en_key'";
    $execute_class_details = mysqli_query($con, $get_class_details);

    $class_exists = mysqli_num_rows($execute_class_details);
    if ($class_exists > 0) {
        #get class details
            $get_additional_info = mysqli_fetch_assoc($execute_class_details);
            $class_id = $get_additional_info["class_id"];
            $creater_id = $get_additional_info["creater_id"];
            $status = $get_additional_info["status"];
            if($status == 0){
                echo "<script>alert('OPPS! Class was canceled.');</script>";
                echo "<script>window.location = 'class_chat.php';</script>";
                }
            else{
//check the user already enrolled
                $user_table = "user_".$user_id;
                
                $enroll_details = "SELECT * FROM $user_table WHERE class_id = '$class_id'";
                $execute_enroll_command = mysqli_query($con, $enroll_details);
                //$user_exist = mysqli_num_rows($execute_enroll_command);
                if(mysqli_num_rows($execute_enroll_command) > 0){
                    echo "<script>alert('You have already enrolled.');</script>";
                }else{
//update the class details
                    $class_table = $creater_id."_".$class_name."_details";
                    $insert_command = "INSERT INTO $class_table (`class_user_id`, `std_id`) VALUES (NULL, '$user_id')";
                    if($execute_insert_command = mysqli_query($con, $insert_command)){
//update user enrollmnts
                        $user_table = "user_".$user_id;
                        $insert_command2 = "INSERT INTO $user_table (`en_id`, `class_id`) VALUES (NULL, '$class_id')";
                        if($execute_insert_command2 = mysqli_query($con, $insert_command2)){
                            echo "<script>alert('Successfully Enrolled! Dont miss the classes');</script>";
                        }

                    }else{
                        echo "<script>alert('Something went wrong! try again');</script>";
                    }
                }
            }
    }
    else{
        echo "<script>alert('Wrong Class name or Enrollment key!');</script>";
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="../../css/class_chat.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<!--add new class-->
                    <div class="col add-class">
                        <img src="../img/enroll.png" alt="Enroll for New Class" onclick="document.getElementById('id01').style.display='block'"/>
                        <p style="margin-top:9%;margin-left:4%;float:left;">Enroll Now</p>
                        <hr style="border-top:2px solid #dbdbdb;margin-top:22%;"/>                      
                    </div>
                </div>
                <div class="row">
                    <div class="col class-details">
                    <div id="Get_Ongoing_classes" >

                    </div >
                    </div>
                </div>
            </div>
<!--right side container-->
            <div class="col private-chat">
<!--navigation bar-->
                  <div class="row navi-row">
                    <div class="col navi-active">
                        <p>Class Chat</p>
                    </div>
                    <a href="../private_chat/private_chat.php" class = "navi"><div class="col">
                      <p>Friends Chat</p>                      
                    </div></a>
                    <a href="../create_class/create_class.php" class = "navi" id="create_clz"><div class="col">
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
                    <div class = "col">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form_send_message">
                        <textarea id="text_area" placeholder="Type Something Here" name="txtmessage" value="<?php echo $txtmsg;?>"></textarea><img src="../img/send.png" alt="Send Image" id="send_button"/>
                        <input type="hidden" name="sent_msg" id = "sent_msg" value="" />
                        <input type="submit" name="send_message" value="" id="btn_Send" onclick="encrypt_message();" />
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!--model box showing classes-->
<div id="id01" style="padding-top:4%" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:436px">

      <div class="w3-center"><br>
        
        <button class="btn fa fa-close" onclick="document.getElementById('id01').style.display='none'"></button>
      </div>
      <h4 style="text-align:center;font-weight:bold;">Let's Learn New Subject</h4>
      <div class="w3-container">
        <div class="row">
          <div class="col all-class">
            <div id="show_all_classes">
              <?php include('show_all_class.php'); ?>
            </div>
          </div>
        </div>
        <hr style="border-top:3px solid #eee"/>
        <div class="row">
          <div class="col class-form">
            <div id = "add_class_form">
                    
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                      <div class="form-group">
                        <p>Class Name*</p>
                        <input id="cName" name ="class_name" type="text" class="form-control" placeholder="Class Name *" value="<?php echo $class_name;?>" required/>
                      </div>
                      <div class="form-group">
                        <p>Enrollment Key*</p>
                        <input name ="enkey" type="text" class="form-control" placeholder="Enrollment Key *" value="" required/>
                      </div>
                      <button onclick="document.getElementById('id01').style.display='none'" type="button" class="btnClose">Close</button>
                      <input id = "submit" name="submit" type="submit" class="btnEnroll"  value="Enroll"/>                                                      
                    </form>
                    
            </div>
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
    
    var tmpid = "<?php echo $clz_pbk ?>";
    
    if(tmpid == ""){
      document.getElementById("text_area").disabled = true;
    }
//get online users
$.ajax({
      cache:true,
      success:function(status){
      setInterval(function(){
      $("#Get_Ongoing_classes").load("ongoing_class.php"); // Add s to the #Get_Online_User to start ajax requests
    },500);
    }
    });;
//get messages
    setInterval(function(){
      var objDiv = document.getElementById("get_chat_logs");
      objDiv.scrollTop = objDiv.scrollHeight;
      $("#get_chat_logs").load("Chat_Log.php");    // Add x to the #Main_Chat_Bo to start ajax requests
    },300);

//load chat header
    setInterval(function(){
      $("#get_chat_header").load("chat_class_detail.php");    
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
//encrypt messages by class public keys
function encrypt_message(){
        var PlainText = document.getElementById("text_area").value;
        var clz_pbk = "<?php echo $clz_pbk; ?>";
        var sent_msg = cryptico.encrypt(PlainText, clz_pbk);
        document.getElementById("sent_msg").value = sent_msg.cipher;
        
     }

</script>
<script type="text/javascript">
$(document).ready(function() {

  $(".show-classes").click(function(){
    var class_id = $(this).attr('id');
    var key;
    var en_key = prompt("Enter the Enrollment Key :", "Enrollment Key*");
    if (en_key == null || en_key == "") {
      alert("Enrollment key is needed!");
    } else {
    key = en_key;
    
    document.getElementById("clz_id").value = class_id;
    document.getElementById("en-key").value = key;

    $("#enroll").trigger("click");
    }
  });

});

</script>

</html>