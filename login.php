<?php

@include './connect.php';

session_start();

if (isset($_POST['submit'])) {

    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pword = $_POST['pword'];

    // Query to check email and plain password
    $select = "SELECT * FROM login WHERE email = '$email' AND password = '$pword'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $_SESSION['email'] = $row['email'];

        // Redirect based on user type
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('Location: ./admin.php');
            exit;
        } elseif ($row['user_type'] == 'fmanager') {
            $_SESSION['manager_name'] = $row['name'];
            header('Location: fmanager_dashboard.php');
            exit;
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('Location: ./dashboard_user.php');
            exit;
        }
    } else {
        $error = "Incorrect email or password!";
    }

    $conn->close();
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url("./air.jpeg");
            background-size: cover;
        }
        .left {
            position: absolute;
            left: 50px;
            padding: 10px;
        }
        .error {
            color: red;
            margin-top: 10px;
            margin-inline: 50px;
        }
    </style>
</head>
<body>
    <div class="left">
        <form action="" method="post">
            <h1>LOGIN</h1>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <label>Password: </label><br>
            <input type="password" name="pword" placeholder="Enter your password" required><br>
            <button type="submit" name="submit">LOGIN</button>
            <p>Not Registered Yet? <a href="user_register.php">Register</a></p>
            <?php if (isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
        </form>
    </div>
</body>
</html>
