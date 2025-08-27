<?php
session_start();  
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-commerce_databse";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
     //echo "Connected successfully";
}
?>
