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
        <button type="button" onclick=document.location ="dashboard_user.html">LOGIN</button>
        <p>Not Registered Yet? <a href="register.html">Register</a><p><br>
</form>
    </div>
    </body>
</html
<?php
require_once("connect.php");
session_start();

if(isset($_POST['submit'])) 
{
$email=$_POST['email'];
$password=$_POST['pword'];
$sql="SELECT * FROM user WHERE uemail = '$email' AND  `password` = '$password' ";
$data=mysqli_query($conn,$sql);

if(!$data) {
echo "no data!";
}
else
{
    $user=[];
    while ($row = mysqli_fetch_array($data)) {
        if(($email == $row['uemail']) && ($password == $row['password']))
        {
            $user= $row;
        }
    }

    if (!$user)
    {
        echo "<script>alert('Invalid user. Check the email and password you entered. If you are not registered, please register.')</script>";
    }
    else
    {
      $userid=$user['user_id'];
      $_SESSION['user_id']= $userid;
      /*$firstlogin =$user['first_login'];*/
    }
}
}
?>
