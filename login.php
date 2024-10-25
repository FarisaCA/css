<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{
        background-image:url("./air.jpeg");
        background-size: cover;
        }
      .left 
      { 
        position: absolute;
        left: 50px;
        padding: 10px;
     }
    </style>
</head>
<body>
    <div class="left">
    <form action="" method="post">
        <h1>LOGIN</h1>
        <label>Email:</label><br>
        <input type="email" name=email placeholder="Enter your email" required><br>
        <label>password: </label><br>
        <input type="password" name="pword" placeholder="Enter your password" required ><br>
        <button type="submit" name="submit">LOGIN</button>
        <p>Not Registered Yet? <a href="register.html">Register</a><p><br>
</form>
    </div>
    </body>
</html>
<?php
require_once("connect.php");
if(isset($_POST['submit'])) 
{
$email=$_POST['email'];
$password=$_POST['pword'];
if($email=="farisa123@gmail.com" && $password == "683547"){
    header('Location:admin_dashboard.php');
    exit();
}
else{
$sql="SELECT * FROM `user` WHERE uemail = '$email' AND  `password` = '$password' ";
$data=mysqli_query($conn,$sql);
    $users=[];
    while($row=mysqli_fetch_array($data))
    {
        if(($email==$row['uemail'])&&($password==$row['password']))
        {
            $users=$row;
        }
    }
    if(!$users)
    {
        echo "<script>alert('invalid user.check the email and password you entered .if you are not registered,please register.')</script>";
    }
    else
    {
        $user_id=$users['user_id'];
        $_SESSION['user_id']=$user_id;
        header('Location:dashboard_user.html');
        exit();
    }}
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                       
?>
