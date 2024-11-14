<?php

@include './connect.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $pword = $_POST['pword'];

   $select_man = " SELECT * FROM manager_reg WHERE email = '$email'";

   $result = mysqli_query($conn, $select_man);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

   $select = " SELECT * FROM login WHERE email = '$email' && password = '$pword'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      $_SESSION['email'] = $row['email'];
      
     if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:./admin.php');

      }else if($row['user_type'] == 'fmanager'){

         $_SESSION['manager_name'] = $row['name'];
         header('location:../Dashboard/M_dashboard/manager_dashboard.php');

      }else if($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:../Dashboard/Stu_dashboard/stu_dashboard.php');

      }
   }
   }else{
      $error[] = 'incorrect email or password!';
   }
   
};
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Login</title>
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
        <p>Not Registered Yet? <a href="user_register.php">Register</a><p><br>
</form>
    </div>
    </body>
</html>

