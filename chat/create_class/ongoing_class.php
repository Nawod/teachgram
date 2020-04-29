 <head>
  <style type="text/css">
  .class_image{
      border-radius: 100%;
      cursor : pointer;
      
  }

  .class_nm{
    font-weight:bold;
    margin-left:15px;
  }

  .classes:hover{
    cursor: pointer;
  }
  .classes:hover > .class_image{
    box-shadow:0px 6px 7px -1px #2c2c30;
    width:40px;
    height:40px;
  }
  .classes:hover > .class_nm{
    text-shadow:0px 4px 4px #8e8f92;
  }
  
  </style>
 </head>

 <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>

<?php
session_start();
$user_id = $_SESSION['user_id'];
#connect db
include('../../db_con.php');

echo "</br>";
//get_created classes

  $query_1 = "SELECT * FROM class_details WHERE creater_id = '$user_id' ORDER BY class_id ASC";
  $run = mysqli_query($con,$query_1)or die(mysqli_error($con));
  echo "</br>";
  
  while($row = mysqli_fetch_assoc($run)){
        $class_id = $row["class_id"];
        $class_name = $row["class_name"];
        if($row["class_dp"]==""){
          echo "<div class='classes' id='$class_id' name='$class_name' alt='$class_name'><img class='class_image' src='../class_dp/default.png' height='35' width='35'title='$class_name'/>&nbsp;&nbsp;"."<p class='class_nm'>".$class_name."</p></div>";
        }else{
          $class_dp = $row["class_dp"];
          echo "<div class='classes' id='$class_id' name='$class_name' alt='$class_name'><img class='class_image' src='../class_dp/$class_dp' height='35' width='35'title='$class_name'/>&nbsp;&nbsp;"."<p class='class_nm'>".$class_name."</p></div>";
        }
        echo "</br>";
  
    
  }
 
 ?>
