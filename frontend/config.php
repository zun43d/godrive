<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password set for XAMPP MySQL
$dbname = "godrive"; // Replace with your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
