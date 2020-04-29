<?php
#connect db
include('db_con.php');

if(!empty($_GET['code']) && isset($_GET['code']))
{
    $code=$_GET['code'];
#check the uniqid in databasse
    $sql=mysqli_query($con,"SELECT * FROM login WHERE activation_code='$code'");
    $num=mysqli_fetch_array($sql);
    if($num>0)
    {
        $st=0;
#check the email is already activated
        $result =mysqli_query($con,"SELECT email FROM login WHERE activation_code='$code' and status ='$st'");
        $result4=mysqli_fetch_array($result);
        if($result4>0)
        {
            $st=1;
            $result1=mysqli_query($con,"UPDATE login SET status='$st' WHERE activation_code='$code'");
            $msg="Your account is activated";
        }
        else
        {
            $msg ="Your account is already active, no need to activate again";
        }
    }
    else
    {
        $msg ="Wrong activation code.";
    }
}
?>