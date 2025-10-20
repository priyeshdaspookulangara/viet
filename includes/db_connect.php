<?php
$servername = "localhost";
$username = "jeoczvkk_priyesh";
$password = "pearlsPearls2#";
$dbname = "jeoczvkk_fruit_export";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>