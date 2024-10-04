<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Reservation System</title>
    <!--link rel="stylesheet" href="styles.css"--> ,<!-- Link to external CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 200px; /* Adjust logo size */
        }

        .login-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="logo.png" alt="Airline Logo" class="logo"> <!-- Replace with your logo file -->
        <h1>Welcome to the Airline Reservation System</h1>
        <p>Book your flights easily and quickly!</p>
        <a href="login.php" class="login-button">Login</a> <!-- Link to the login page -->
    </div>

</body>
</html>
