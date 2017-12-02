<?php
$pass = "";
$servername = "localhost";
$username = "root";
$db = "Servo";
session_start();
$conn = new mysqli($servername, $username, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>