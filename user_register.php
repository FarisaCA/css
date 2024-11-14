<?php

@include './connect.php';

$name = '';
$email = '';
$pword = '';
$cpword = '';
$phone = '';
$address = '';
$gender = '';
$user_type = 'user';
$error = [];
$success = [];

if(isset($_POST['submit']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pword=$_POST['pword'];
    $cpword=$_POST['cpword'];
    $phone=trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $address=$_POST['address'];
    $gender=$_POST['gender'];
   
// Validate inputs
if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
    $error['name'] = 'Full name is required and can only contain letters and spaces.';
}

if (empty($email)) {

    $error['email'] = 'Email is required.';

} else {
    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user_reg WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $error['email'] = 'This email is already registered.';
    }
}

if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
    $error['phone'] = 'Invalid phone number. Must be 10 digits.';
}

if (empty($address)) {
    $error['address'] = 'Address is required.';
}

if (empty($pword) || empty($cpword)) {
    $error['pword'] = 'Password is required.';
} elseif ($pword !== $cpword) {
    $error['cpword'] = 'Passwords do not match.';
}


    $select = " SELECT * FROM login WHERE email = '$email' && password = '$pword' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }


   if (empty($error)) {

         $insert="INSERT INTO user_reg(name, email, number, address, gender, user_type) VALUES('$name','$email','$phone','$address','$gender','$user_type')";
         mysqli_query($conn, $insert);

         $insert_login = "INSERT INTO login (email, password, user_type) VALUES ('$email','$pword','$user_type')";
         mysqli_query($conn, $insert_login);

         $success[] = "Registration successful!";
         header('Refresh: 2; URL=login.php');  // Redirects after 2 seconds
        
      }
   
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style-register.css">
        <style>
           .invalid-feedback {
            color: #ff0000;
            font-size: 10px;
            margin: -7px 1px 12px;
        }
        .form-group {
            margin-bottom: -9px;
        }
        .input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            box-sizing: border-box;
            
        }
        .radio-group{
                margin-top:  18px;
            }
            .radio-container{
                margin: 20px;
            }
            .ltext{
            font-size: 25px;
            color: #230000;     
            padding-inline:40px            
            }
            </style>
        
    </head>
    <body>
        <form action=""  method="post">
            <h3 class="ltext">USER REGISTRATION</h3>
            <!-- <img src="./logo.png"> -->
            <input class="input" type="hidden" name="usertype" value="fmanager">

            <div class="form-group">
                <input class="input <?php echo isset($error['name']) ? 'is-invalid' : ''; ?>" type="text" name="name"  value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" placeholder="Enter your name" ><br>
            <?php if (isset($error['name'])): ?>
                                 <div class="invalid-feedback">
                                <?php echo $error['name']; ?>
                                </div>
                             <?php endif; ?>
                             </div>

                             <div class="form-group">
                             <input class="input  <?php echo isset($error['email']) ? 'is-invalid' : ''; ?>" type="email" name="email"  value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" placeholder="Enter your email" ><br>
            <?php if (isset($error['email'])): ?>
                                 <div class="invalid-feedback">
                                <?php echo $error['email']; ?>
                                </div>
                             <?php endif; ?>
                             </div>

                             <div class="form-group">
                             <input class="input  <?php echo isset($error['pword']) ? 'is-invalid' : ''; ?>" type="password" name="pword"  value="<?php echo isset($pword) ? htmlspecialchars($pword) : ''; ?>" placeholder="Enter password" ><br>
            <?php if (isset($error['pword'])): ?>
                                 <div class="invalid-feedback">
                                <?php echo $error['pword']; ?>
                                </div>
                             <?php endif; ?>
                             </div>

                             <div class="form-group">
                             <input class="input  <?php echo isset($error['cpword']) ? 'is-invalid' : ''; ?>" type="password" name="cpword"  value="<?php echo isset($cpword) ? htmlspecialchars($cpword) : ''; ?>" placeholder="Confirm your password" ><br>
            <?php if (isset($error['cpword'])): ?>
                                 <div class="invalid-feedback">
                                <?php echo $error['cpword']; ?>
                                </div>
                             <?php endif; ?>
                             </div>

                             <div class="form-group">
                             <input class="input  <?php echo isset($error['phone']) ? 'is-invalid' : ''; ?>" type="number" name="phone"  value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" placeholder="Enter your contact number"><br>
            <?php if (isset($error['phone'])): ?>
                                 <div class="invalid-feedback">
                                <?php echo $error['phone']; ?>
                                </div>
                             <?php endif; ?>
                             </div>

          <div class="form-group">
                             <input class="input  <?php echo isset($error['address']) ? 'is-invalid' : ''; ?>" type="text" name="address"  value="<?php echo isset($address) ? htmlspecialchars($address) : ''; ?>"placeholder="Enter your address" ><br>
            <?php if (isset($error['address'])): ?>
                                 <div class="invalid-feedback">
                                <?php echo $error['address']; ?>
                                </div>
                             <?php endif; ?>
                             </div>

                             <div class="radio-group">
                 <label class="radio-container">Male
                     <input type="radio" name="gender" value="male" checked>
                     <span class="checkmark"></span>
                 </label>
                 <label class="radio-container">Female
                    <input type="radio" name="gender" value="female">
                    <span class="checkmark"></span>
                </label>
                <label class="radio-container">Other
                     <input type="radio" name="gender" value="other" >
                     <span class="checkmark"></span>
                 </label>
            </div>


        <button type="submit" name="submit" >REGISTER</button>
        </form>
    </body>
</html>
