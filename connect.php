<?php
$servername="localhost";
$username="root";
$password="";
$dbname="airline";

$conn=new mysqli($servername, $username, $password);

if($conn->connect_error){
    die("connection failed: " .$conn->connect_error);

}

$sql="CREATE DATABASE IF NOT EXISTS $dbname";
$con_res=$conn->query($sql);
if(!$con_res){
    echo"error creating database: ";
}
$conn->select_db($dbname);
$sql="CREATE TABLE IF NOT EXISTS user(
      user_id INT(5) PRIMARY KEY AUTO_INCREMENT,
      uname VARCHAR(20) NOT NULL,
      uemail VARCHAR(50) NOT NULL,
      password VARCHAR(20) NOT NULL,
      gender VARCHAR(20) NOT NULL,
      uphone VARCHAR(10) NOT NULL,
      ucity VARCHAR(100) NOT NULL
     )";

if($conn->query($sql) === FALSE){
    die("error creating table: ".$conn->error);
}
$sql="ALTER TABLE user AUTO_INCREMENT = 100";
if($conn->query($sql) === FALSE){
    die("error running the query: ".$conn->error);
}
$sql="CREATE TABLE IF NOT EXISTS flight(
       flight_no VARCHAR(6) PRIMARY KEY, 
       departure VARCHAR(50) NOT NULL,
       d_date DATE NOT NULL,
       d_time TIME NOT NULL,
       arrival VARCHAR(50) NOT NULL,
       a_date DATE NOT NULL,
       a_time TIME NOT NULL ,
       price INT NOT NULL                                                                               
    )";
        if($conn->query($sql) === FALSE)
        {
            die("error creating table: ".$conn->error);
        }
        /*$sql= "CREATE TABLE IF NOT EXISTS admins(
        admin_id INT(3) AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20),
        role VARCHAR(50) DEFAULT 'Admin'
        )";*/
        if (!$conn->query($sql)) {
           $error = $conn->error;
                    echo "Error creating table: $error";
            }
       if (!$conn->query($sql)) 
       {
            $error = $conn->error;
            echo "Error running the query: $error";
        }
?>
