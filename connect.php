<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airline";

session_start();
$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sql)) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create the user table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS user (
    user_id INT(5) PRIMARY KEY AUTO_INCREMENT,
    uname VARCHAR(20) NOT NULL,
    uemail VARCHAR(50) NOT NULL,
    password VARCHAR(20) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    uphone VARCHAR(15) NOT NULL,
    ucity VARCHAR(100) NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Set the AUTO_INCREMENT value for user table
$sql = "ALTER TABLE user AUTO_INCREMENT = 100";
if ($conn->query($sql) === FALSE) {
    die("Error running the query: " . $conn->error);
}

// Create the flight table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS flight (
    flight_id INT PRIMARY KEY AUTO_INCREMENT,
    flight_no VARCHAR(6), 
    departure VARCHAR(50) NOT NULL,
    d_date DATE NOT NULL,
    d_time TIME NOT NULL,
    arrival VARCHAR(50) NOT NULL,
    a_date DATE NOT NULL,
    a_time TIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    st_atus BOOLEAN DEFAULT true
)";


if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

        $sql= "CREATE TABLE IF NOT EXISTS admins(
        admin_id INT(3) AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20),
        role VARCHAR(50) DEFAULT 'Admin'
        )";
        if (!$conn->query($sql)) {
           $error = $conn->error;
                    echo "Error creating table: $error";
            }

       
?>     
