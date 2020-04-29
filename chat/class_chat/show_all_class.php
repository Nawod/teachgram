
<head>
  <style type="text/css">
  .show-class_image{
      border-radius: 100%;
      cursor : pointer;
  }

  .show-classes:hover{
    cursor: pointer;
  }
  .show-classes:hover > .show-class_image{
    box-shadow:0px 6px 7px -1px #2c2c30;
    width:40px;
    height:40px;
  }
  .show-classes:hover > .show-class_nm{
    text-shadow:0px 4px 4px #8e8f92;
  }
  .show-clz{
    text-align:center;
  }
  #enroll{
    display:none;
  }
  </style>
 </head>

 <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php
//as a included page session start didnt add
if(!isset($_SESSION['user_id']))
{
 header('location:../../login.php');
}
$user_id = $_SESSION['user_id'];
#connect db
include('../../db_con.php');


//enroll to class
if (isset($_POST["enroll"])) {
  $clz_id = $_POST['clz_id'];
  $en_key1 =  $_POST['en_key'];
  
  $clz_id = mysqli_real_escape_string($con, $clz_id);
  $en_key1 = mysqli_real_escape_string($con, $en_key1);

  $clz_id = xss_clean($clz_id);
  $en_key1 = xss_clean($en_key1);

#check the class exist
  $get_clz_details = "SELECT * FROM class_details WHERE class_id = '$clz_id' AND enrollment_key = '$en_key1'";
  $execute_clz_details = mysqli_query($con, $get_clz_details);

  $clz_exists = mysqli_num_rows($execute_clz_details);
  if ($clz_exists > 0) {
      #get class details
          $get_add_info = mysqli_fetch_assoc($execute_clz_details);
          $class_name = $get_add_info["class_name"];
          $creater_id = $get_add_info["creater_id"];
          $status = $get_add_info["status"];
          if($status == 0){
              echo "<script>alert('OPPS! Class was canceled.');</script>";
              echo "<script>window.location = 'class_chat.php';</script>";
              }
          else{
//check the user already enrolled
              $user_table = "user_".$user_id;
              
              $enroll_details = "SELECT * FROM $user_table WHERE class_id = '$clz_id'";
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
                      $insert_command2 = "INSERT INTO $user_table (`en_id`, `class_id`) VALUES (NULL, '$clz_id')";
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
          echo "<script>alert('Wrong Enrollment key!');</script>";
      }
}

//form
echo "<form method='POST' action='' >";
echo "<input type='hidden' id='clz_id' name='clz_id' value='' />";
echo "<input type='hidden' id='en-key' name='en_key' value='' />";
echo "<input type='submit' name='enroll' value='' id='enroll' />";
echo "</form>";

echo "<div class='row'>";
//get enrolled classes

  $query_1 = "SELECT * FROM class_details";
  $run = mysqli_query($con,$query_1)or die(mysqli_error($con));
  echo "</br>";
  while($row = mysqli_fetch_array($run)){
    echo "<div class='col-lg show-clz'>";
    $class_id = $row["class_id"];
    $class_name = $row["class_name"];  
          if($row["class_dp"]==""){
              echo "<div class='show-classes' id='$class_id' name='$class_name' alt='$class_name'><img class='show-class_image' src='../class_dp/default.png' height='35' width='35'title='$class_name'/>&nbsp;&nbsp;"."<p class='show-class_nm' id='clz_name'>".$class_name."</p></div>";
          }else{
              $class_dp = $row["class_dp"];
              echo "<div class='show-classes' id='$class_id' name='$class_name' alt='$class_name'><img class='show-class_image' src='../class_dp/$class_dp' height='35' width='35'title='$class_name'/>&nbsp;&nbsp;"."<p class='show-class_nm' id='clz_name'>".$class_name."</p></div>";
          }
    echo "</div>";
  }
  echo "</div>";
  

 ?>
