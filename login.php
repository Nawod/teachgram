<?php
session_start();

$err = '';
if (isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["pass"];
    $public_key = $_POST["pbk"];
#connect db
include('db_con.php');

    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $hash_password = md5($password);
//validate inputs against xss
    $email = xss_clean($email);
    $password = xss_clean($password);
    
#validate user
    $user_details = "SELECT * FROM login WHERE email=? AND Password = ?";
    $stmt = $con->prepare($user_details); 
    $stmt->bind_param("ss", $email , $hash_password);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $rows = $result->fetch_assoc();
    if ($rows) {
#get user details
        $username = $rows["first_name"];
        $user_id = $rows["user_id"];
        $user_type = $rows["user_type"];
        $user_status = $rows["status"];
        $user_pbkey = $rows["public_key"];
        $stmt -> close();
#check the email is verified
       if($user_status == 0){
        echo "<script>alert('Please verify your acount! Check your emails');</script>";
        echo "<script>window.location = 'login.php';</script>";
        }
    else{

//set the session
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['rec_user_id'] = $user_id;
        $_SESSION['rsa_p'] = $password;
        $_SESSION['user_type'] = $user_type;
//regenerate session id for mitigate session hijack
        session_regenerate_id();

        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        
        if ($_SESSION['user_agent'] != $_SERVER['HTTP_USER_AGENT'])
        {
        exit;
        }
        ini_set( 'session.use_only_cookies', TRUE );                
        ini_set( 'session.use_trans_sid', FALSE );
//check user online status

        $login_details = "SELECT * FROM login_details WHERE user_id = ?";
        $stmt = $con->prepare($login_details); 
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $rows = $result->fetch_assoc();
        if ($rows) {
           
            $login_details_id = $rows["login_details_id"];
            $_SESSION['login_details_id'] = $login_details_id;

            $is_type = 'yes';
            
            $update_status = "UPDATE login_details SET is_type=? WHERE user_id=?";
            $stmt= $con->prepare($update_status);
            $stmt->bind_param("si",$is_type, $user_id);
            $update_last_activity = "UPDATE login_details SET last_activity = CURRENT_TIMESTAMP WHERE user_id = $user_id";
            $execute_last_activity = mysqli_query($con, $update_last_activity);
            if($stmt->execute()){
                $stmt -> close();  
            }
            else{
                echo "<script>alert('online status update error');</script>";}
        
        } else {
#update user online status
            $insert_command = "INSERT INTO login_details (`login_details_id`, `user_id`,`last_activity`, `is_type`) VALUES (NULL, '$user_id', CURRENT_TIMESTAMP,'yes')";
            if($execute_insert_command = mysqli_query($con, $insert_command)){

                $login_details_id = mysqli_insert_id($con);
                $_SESSION['login_details_id'] = $login_details_id;
                mysqli_close($con);
                

            }
            else{
                echo "<script>alert('online status insert error');</script>";}
            
        }
//check the public key
            if($user_pbkey == ""){
                $update_command = "UPDATE login SET public_key = '$public_key' WHERE user_id ='$user_id'";
                if($execute_update_command = mysqli_query($con, $update_command)){
                    $_SESSION['public_k'] = $public_key;
                    $_SESSION['rec_public_key'] = $public_key;
                }
            }
            else{ 
                $_SESSION['public_k'] = $public_key;
                $_SESSION['rec_public_key'] = $public_key;
            }
             
//create a new table for class enrollmnt details
            $tabele_name = "user_".$user_id;
            $command_query = "SELECT * FROM information_schema.tables WHERE table_schema = 'teachgram' AND table_name = '$tabele_name' LIMIT 1";
            $execute_command_query = mysqli_query($con,$command_query);
            $check_table_existence = mysqli_num_rows($execute_command_query);

            if($check_table_existence>0){
                header("Location:chat/private_chat/private_chat.php");
            }
            else{
                $create_table_query = "CREATE TABLE `$tabele_name`(`en_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `class_id` int(11) NOT NULL)ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT";
                $execute_create_table_query = mysqli_query($con,$create_table_query)or die(mysqli_error($con));

                if($execute_create_table_query){
                    header("Location:chat/private_chat/private_chat.php");
                }
            }
    
    }

    } else {
        $err = "Wrong Username or Password";
    }
} else {

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
    <title>TEACHGRAM-LOGIN</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <link href="css/login_cs.css" rel="stylesheet">
<!--encryption api-->
        <script language="JavaScript" type="text/javascript" src="api/jsbn.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/random.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/hash.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/rsa.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/aes.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/api.js"></script>
</head>  
<body>
<div class="container register" >
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="chat/img/teachgram.png" alt=""/>
            <h3>TEACHGRAM</h3>
            <p>Let's Learn together!</p>
            <button type="button" name="login" class="btnRegister" onclick="window.location.href = 'signup.php';">Register</button><br/>
        </div>
        <div class="col-md-9 register-right">
            <!--login form-->
                <div class="tab-content" id="myTabContent">
                        <!--student registration form-->
                            <h3 class="register-heading">Log in to TEACHGRAM</h3>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="row register-form">
                                    <div class="col">                                       
                                        <div class="form-group">
                                            <p>Email<span class="error" style="color:#FF0000;" >* <?php echo $err;?></span></p>
                                            <input name ="email" type="text" class="form-control" placeholder="Email *" value="" required/>
                                        </div>
                                        <div class="form-group">
                                            <p>Password*</p>
                                            <input id="pass" name ="pass" type="password" class="form-control" placeholder="Password *" value="" required/>
                                            <input id="pbk" name ="pbk" type="hidden" class="form-control" value="" />
                                        </div>
                                        <input id = "submit" name="submit" type="submit" class="btnLogin"  value="Login" onclick="genarate_public_key()"/>                                        
                                    </div>
                                </div>
                            </form>
                           
                            
                </div>
        </div>
            
    </div>
</div>
</body>
<!--generate public key-->
<script>
function genarate_public_key(){ 
    
    var PassPhrase = document.getElementById("pass").value;
    var Bits = 512;

    var MattsRSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
    var MattsPublicKeyString = cryptico.publicKeyString(MattsRSAkey);
    document.getElementById("pbk").value = MattsPublicKeyString;
   // $('#submit').trigger("click");
}

</script>
</html>