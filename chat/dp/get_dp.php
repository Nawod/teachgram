<?php
include('../../db_con.php');

$user_id = $_SESSION['user_id'];

#upload profile pic
if(isset($_POST["submit_file"])){

    move_uploaded_file($_FILES["file"]["tmp_name"],"../profile_picture/".$_FILES["file"]["name"]);
    
    $myfiles = $_FILES["file"]["name"];
    
    $result=mysqli_query($con,"UPDATE login SET Profile_Picture='$myfiles' WHERE user_id = '$user_id'");
    if($result){
      echo "<script>alert('Profile Picture successfully uploaded!');</script>";
    }
    else{
        echo "<script>alert('Error! Profile Picture not uploaded');</script>";
    }
    }

?>
<div id="top-navigation-username">

    <span id="my_profile_picture" style="cursor: pointer;"></span>
    
    <!-- Working with the dp -->
    <div id="dp_form_holder" style="display:none">
    <form method="post" action="" enctype="multipart/form-data">
      <input type="file" name="file" id="file"/>
      <input type="submit" name="submit_file" id="submit_file"/>
    </form>
    </div>

    <p><?php echo $_SESSION['username'];?></p>
</div>
  
