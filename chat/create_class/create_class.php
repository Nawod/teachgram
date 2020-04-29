<?php declare(strict_types=1);

include('../../db_con.php');

session_start();
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'];
//for showing errors
$nameErr = $keyErr1 = $keyErr2 ='';
$class_name = '';

if(isset($_POST["submit"])){
  #assign input data to new varriables
  $class_name = $_POST["class_name"];
  $en_key = $_POST["en_key"];
  $con_key = $_POST["con_key"];
  $public_key = $_POST["pbk"];
//validating inputs against xss & sql  
  $first_name = mysqli_real_escape_string($con,$class_name);
  $con_key = mysqli_real_escape_string($con,$con_key);
  $en_key = mysqli_real_escape_string($con,$en_key);

  $status = 1;
  $add_std = 0;
  $creater_id = $user_id;

  $class_name = xss_clean($class_name);

#validating inputs
  if (empty($class_name)) {
    $nameErr = "Class Name is required!";
  } else if (!preg_match("/^[a-zA-Z_]*$/",$class_name)) {
    $nameErr = "Only letters allowed!";
  }

  if (empty($en_key)) {
    $keyErr1 = "Enrollment Key is required!";
  }else if (strlen($en_key) < 6) {
    $keyErr1 = "Key must have minimum 6 characters!";
  }
  if (empty($con_key)) {
    $keyErr2 = "Confirm the Key";
  }else if ($en_key != $con_key) {
    $keyErr2 = "Key doesn't match!";
  }
  if($public_key == ""){
    echo "<script>alert('empty key');</script>";
  }
  else{
    if($nameErr=="" && $keyErr2=="" && $keyErr1==""){
    #Check the email already used
      $check_class = "SELECT * FROM class_details where class_name='$class_name'";
      $execute_check_class=mysqli_query($con,$check_class);
      $check_class_rows=mysqli_num_rows($execute_check_class);
 
      if($check_class_rows)
      {
        $nameErr="Class already exists!";
      }
      else
      {
#create new tables for class
        $tabele_name1 = $user_id."_".$class_name."_details";
        $create_table_query1 = "CREATE TABLE `$tabele_name1`(`class_user_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `std_id` int(11) NOT NULL)ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT";
        $execute_create_table_query1 = mysqli_query($con,$create_table_query1)or die(mysqli_error($con));

        if($execute_create_table_query1){
          $tabele_name2 = $user_id."_".$class_name."_msgs";
          $create_table_query2 = "CREATE TABLE `$tabele_name2`(`msg_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `sender_id` int(11) NOT NULL, `messages` varchar(40000) NOT NULL, `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT";
          $execute_create_table_query2 = mysqli_query($con,$create_table_query2)or die(mysqli_error($con));

          if($execute_create_table_query2){
            #insert data into user_table
            $create_class_command = "INSERT INTO class_details (`class_id`, `class_name`, `creater_id`, `enrollment_key`, `class_pbk`, `status` , `add_std`) VALUES (NULL, '$class_name', '$creater_id', '$en_key' ,'$public_key', '$status','$add_std')";
            $execute_create_command = mysqli_query($con,$create_class_command);
            $last_id = mysqli_insert_id($con);
            #update enrollemnt status
            $update_class_table = "INSERT INTO $tabele_name1(`class_user_id`,`std_id`) VALUES (NULL , '$user_id')";
            if($execute_update_table = mysqli_query($con,$update_class_table)){
              $tabele_name = "user_".$user_id;
              $update_user_table = "INSERT INTO $tabele_name(`en_id`,`class_id`) VALUES (NULL , '$last_id')";

              if($execute_update = mysqli_query($con,$update_user_table)){
                echo "<script>alert('Class is now online!');</script>";
              }
            }
          }
        }
        else{
          echo "<script>alert('Sorry, Somthing Wrong! Try again');</script>";
        }
      }
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
    
    <link href="../../css/create_class.css" rel="stylesheet">
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
                    <div class="col show-class">
                        <p>Ongoing Classes</p>
                        <hr/>
                        
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
            <div class="col create-chat">
<!--navigation bar-->
                <div class="row navi-row">
                    <a href="../class_chat/class_chat.php" class = "navi"><div class="col">
                        <p>Class Chat</p>
                    </div></a>
                    <a href="../private_chat/private_chat.php" class = "navi"><div class="col">
                      <p>Friends Chat</p>                      
                    </div></a> 
                    <div class="col navi-active">
                        <p>Create Class</p>
                    </div>
                    <a href="#" class = "navi"><div class="col">
                        <p>Profile</p>
                    </div></a>
                </div>
          
<!--create class form-->
                <div class="row">
                    <div class="col">
                      <h3  class="class-heading">Let's Teach New Subject</h3>
                        <div id="create-class-form">
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                              <div class="form-group">
                                <p>Class Name<span class="error" style="color:#FF0000;" >* <?php echo $nameErr;?></span></p>
                                <input type="text"  class="form-control" name="class_name" placeholder="Class Name *" value="<?php echo $class_name;?>"/>
                              </div>
                              <div class="form-group">
                                  <p>Enrollment Key<span class="error" style="color:#FF0000;" >* <?php echo $keyErr1;?></span></p>
                                  <input id="en_key" name ="en_key" type="text" class="form-control"  placeholder="Enrollment Key *" value="" />
                              </div>
                              <div class="form-group">
                                  <p>Confirm Key<span class="error" style="color:#FF0000;" >* <?php echo $keyErr2;?></span></p>
                                  <input name ="con_key" type="text" class="form-control"  placeholder="Confirm Key *" value="" />
                                  <input id="pbk" name ="pbk" type="hidden" class="form-control" value="" />
                              </div>
                              <input id = "submit" name="submit" type="submit" class="btnAddClass"  value="Create" onclick="genarate_public_keys()"/>
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
//get online users
    $.ajax({
      cache:true,
      success:function(status){
      setInterval(function(){
      $("#Get_Ongoing_classes").load("ongoing_class.php"); // Add s to the #Get_Ongoing_User to start ajax requests
    },500);
    }
    });

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

});
</script>
<script>
//generate the class public key
function genarate_public_keys(){ 
    
    var PassPhrase = document.getElementById("en_key").value;
    var Bits = 512;

    var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
    var PublicKeyString = cryptico.publicKeyString(RSAkey);
    document.getElementById("pbk").value = PublicKeyString;

}

</script>
</html>