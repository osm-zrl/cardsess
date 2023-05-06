<?php

// Replace the variables below with your own database information
$host = "localhost";
$username = "root";
$password = "";
$dbname = "student_card";

// Create a new MySQLi object
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

