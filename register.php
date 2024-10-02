<?php
require_once("connect.php");
if(isset($_POST['REGISTER']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pword=$_POST['pword'];
    $cpword=$_POST['cpword'];
    $gender=$_POST['gender'];
    $phone=$_POST['phone'];
    $city=$_POST['city'];
    if($pword == $cpword){
        $data=mysqli_query($conn,$sql);
        $data=mysqli_query($conn,$sql);
        $data=mysqli_query($conn,$sql);
        $sql=$sql = "INSERT INTO `user` (`user_id`, `uname`, `uemail`, `password`, `gender`, `uphone`, `ucity`) VALUES ('$user_id', '$name', '$email', '$pword', '$gender', '$phone', '$city')";
        $data=mysqli_query($conn,$sql);
        if(!$data)
        {
            echo"error inserting values";
        }
        header("Location:/myproject/login.php");
    }
    else{
        echo"<script><alert>password doesn't match re enter</alert></script>";
    }
}
?>