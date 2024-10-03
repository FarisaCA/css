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
$sql="CREATE TABLE IF NOT EXISTS user(
       flight_id INT(5) PRIMARY KEY 
       from_port VARCHAR(50) NOT NULL,
       to_port VARCHAR(50) NOT NULL,
                                                                                        
        "
?>
