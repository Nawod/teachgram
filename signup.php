<?php
#connect db
include('db_con.php');

//for showing errors
  $err = $emailErr = $nameErr = $nameErr2 = $passErr = $passErr2 ='';
  $first_name = $last_name = $email = '';

if(isset($_POST["submit"])){
#assign input data to new varriables
  $first_name = $_POST["fname"];
  $last_name = $_POST["lname"];
  $email = $_POST["email"];
  $user_password = $_POST["pass"];
  $con_password = $_POST["con_pass"];
  $user_type = $_POST["usertype"];
  $public_key = $_POST["pbk"];
  
//validating inputs against xss & sql  
  $first_name = mysqli_real_escape_string($con,$first_name);
  $last_name = mysqli_real_escape_string($con,$last_name);
  $email = mysqli_real_escape_string($con,$email);
  $user_password = mysqli_real_escape_string($con,$user_password);
  $con_password = mysqli_real_escape_string($con,$con_password);
  $user_type = mysqli_real_escape_string($con,$user_type);

  $uniqid = md5($email.time());
  $status = 1;#this should be 0. As mail function not working localhost, assign 1.

  $first_name = xss_clean($first_name);
  $last_name = xss_clean($last_name);
  $email = xss_clean($email);
  $user_type = xss_clean($user_type);
  $user_password = xss_clean($user_password);
  $con_password = xss_clean($con_password);
  $null = NULL;
  $profile_picture = '';
#validating inputs
  if (empty($first_name)) {
    $nameErr = "First Name is required!";
  } else if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
    $nameErr = "Only letters allowed!";
  }
  if (empty($last_name)) {
    $nameErr2 = "Last Name is required!";
  } else if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
    $nameErr2 = "Only letters allowed!";
  }

  if (empty($email)) {
    $emailErr = "Email is required!";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format!";
  }

  if (empty($user_password)) {
    $passErr = "Password is required!";
  }else if (strlen($user_password) < 8) {
    $passErr = "Password must have minimum 8 characters!";
  }
  if (empty($user_password)) {
    $passErr2 = "Confirm Password";
  }else if ($user_password != $con_password) {
    $passErr = "Password doesn't match!";
  }
if($public_key == ""){
  echo "<script>alert('empty key');</script>";
}
else{
    if($nameErr=="" || $nameErr2=="" || $emailErr=="" || $passErr=="" || $passErr2==""){

#Check the email already used
        $check_email = "SELECT * FROM login WHERE email=?";
        $stmt = $con->prepare($check_email); 
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $check_mails_rows = $result->fetch_assoc();  
        if($check_mails_rows)
        {
          $emailErr="Email already exists!";
        }
        else
        {
          $stmt -> close();
#insert data into user_table
          #hash the password
          $hash_password = md5($user_password);
          $register_user_command = "INSERT INTO login (user_id, first_name, last_name, email, user_type, Password , Profile_Picture ,activation_code, status , public_key) VALUES (?,?,?,?,?,?,?,?,?,?)";
          $stmt= $con->prepare($register_user_command);
          $stmt->bind_param("ssssssssss", $null, $first_name,$last_name, $email ,$user_type, $hash_password ,$profile_picture ,$uniqid , $status , $public_key );
          if($stmt->execute()){
            $stmt -> close();
#send verification e-mail
          $to=$email;
          $msg= "Thanks for new Registration.";
          $subject="Email verification (teachgram.com)";
          $headers .= "MIME-Version: 1.0"."\r\n";
          $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
          $headers .= 'From:TeachGram | Online Class Environment <info@teachgram.com>'."\r\n";
          $ms.="<html></body><div><div>Dear $first_name $last_name,</div></br></br>";
          $ms.="<div style='padding-top:8px;'>Please click The following link For verifying and activation of your account</div>
          <div style='padding-top:10px;'><a href='http://127.0.0.1/teachgram1/email_verification.php?code=$uniqid'>Click Here</a></div>
          <div style='padding-top:4px;'>Powered by <a>teachgram.com</a></div></div>
          </body></html>";
          mail($to,$subject,$ms,$headers);
          echo "<script>alert('Registration successful, please verify the Email');</script>";
          echo "<script>window.location = 'login.php';</script>";
            

          }else{
            echo "<script>alert('Sorry, Somthing Wrong! Try again');</script>";
          }
        }
  }else{
    //echo "<script>alert('Error Occurs!');</script>";
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
    <title>TEACHGRAM-SIGNUP</title>  
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <link href="css/signup_cs.css" rel="stylesheet">
    <!--encryption api-->
    <script language="JavaScript" type="text/javascript" src="api/jsbn.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/random.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/hash.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/rsa.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/aes.js"></script>
        <script language="JavaScript" type="text/javascript" src="api/api.js"></script>
</head>  

<body>  
<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="chat/img/teachgram.png" alt=""/>
                        <h3>TEACHGRAM</h3>
                        <p>Let's Learn together!</p>
                        <button type="button" name="login" class="btnLogin" onclick="window.location.href = 'login.php';">Login</button><br/>
                    </div>
                    <div class="col-md-9 register-right">
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Student</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Teacher</a>
                            </li>
                        </ul>
                        <!--registration form-->
                        <div class="tab-content" id="myTabContent">
                        <!--student registration form-->
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Register as a Student</h3>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="row register-form">
                                        <div class="col-md-6">                                       
                                            <div class="form-group">
                                                <p>First Name<span class="error" style="color:#FF0000;" >* <?php echo $nameErr;?></span></p>
                                                <input name ="fname" type="text" class="form-control" placeholder="First Name *" value="<?php echo $first_name;?>" />
                                            </div>
                                            <div class="form-group">
                                                <p>Last Name<span class="error" style="color:#FF0000;" >* <?php echo $nameErr2;?></span></p>
                                                <input name ="lname" type="text" class="form-control" placeholder="Last Name *" value="<?php echo $last_name;?>" />
                                            </div>
                                            <div class="form-group">
                                                <p>Password<span class="error" style="color:#FF0000;" >* <?php echo $passErr;?></span></p>
                                                <input id="pass1" name ="pass" type="password" class="form-control" placeholder="Password *" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"/>
                                            </div>
                        
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p>Email<span class="error" style="color:#FF0000;" >* <?php echo $emailErr;?></span></p>
                                                <input name ="email" type="email" class="form-control" placeholder="Your Email *" value="<?php echo $email;?>" />
                                            </div>
                                            <div class="form-group">
                                                <p>Position*</p>
                                                <input type="text"  class="form-control" value="Student" disabled/>
                                                <input type="hidden" value="Student" name ="usertype" />
                                            </div>
                                            <div class="form-group">
                                                <p>Confirm Password<span class="error" style="color:#FF0000;" >* <?php echo $passErr2;?></span></p>
                                                <input name ="con_pass" type="password" class="form-control"  placeholder="Confirm Password *" value="" />
                                               <input id="pbk" name ="pbk" type="hidden" class="form-control" value="" />
                                            </div>
                                            <input id = "submit" name="submit" type="submit" class="btnRegister"  value="Register" onclick="genarate_public_keys()"/>
                                        </div>
                                </div>
                                </form>
                            </div>
                            <!--teachers registration form-->
                            <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h3  class="register-heading">Register as a Teacher</h3>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="row register-form">
                                        <div class="col-md-6">                                       
                                            <div class="form-group">
                                                <p>First Name<span class="error" style="color:#FF0000;" >* <?php echo $nameErr;?></span></p>
                                                <input name ="fname" type="text" class="form-control" placeholder="First Name *" value="<?php echo $first_name;?>" />
                                            </div>
                                            <div class="form-group">
                                                <p>Last Name<span class="error" style="color:#FF0000;" >* <?php echo $nameErr2;?></span></p>
                                                <input name ="lname" type="text" class="form-control" placeholder="Last Name *" value="<?php echo $last_name;?>" />
                                            </div>
                                            <div class="form-group">
                                                <p>Password<span class="error" style="color:#FF0000;" >* <?php echo $passErr;?></span></p>
                                                <input id="pass2" name ="pass" type="password" class="form-control" placeholder="Password *" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
                                            </div>
                        
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p>Email<span class="error" style="color:#FF0000;" >* <?php echo $emailErr;?></span></p>
                                                <input name ="email" type="email" class="form-control" placeholder="Your Email *" value="<?php echo $email;?>" />
                                            </div>
                                            <div class="form-group">
                                                <p>Position*</p>
                                                <input type="text"  class="form-control" value="Teacher" disabled/>
                                                <input type="hidden" value="Teacher" name ="usertype" />
                                            </div>
                                            <div class="form-group">
                                                <p>Confirm Password<span class="error" style="color:#FF0000;" >* <?php echo $passErr2;?></span></p>
                                                <input name ="con_pass" type="password" class="form-control"  placeholder="Confirm Password *" value="" />
                                                <input id="pbk" name ="pbk" type="hidden" class="form-control" value="" />
                                            </div>
                                            <input id = "submit" name="submit" type="submit" class="btnRegister"  value="Register" onclick="genarate_public_keyt()"/>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
</body>  
<!--generate public key-->
<script>
function genarate_public_keys(){ 
    
    var PassPhrase = document.getElementById("pass1").value;
    var Bits = 512;

    var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
    var PublicKeyString = cryptico.publicKeyString(RSAkey);
    document.getElementById("pbk").value = PublicKeyString;

}
</script>
<script>
function genarate_public_keyt(){ 
    
    var PassPhrase = document.getElementById("pass2").value;
    var Bits = 512;

    var RSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
    var PublicKeyString = cryptico.publicKeyString(RSAkey);
    document.getElementById("pbk").value = PublicKeyString;

}
</script>
</html>
 