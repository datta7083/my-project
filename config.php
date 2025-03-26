<?php
$host = "localhost"; // Your database host (default: localhost)
$user = "root";      // Your database username (default: root)
$pass = "";          // Your database password (default: empty for XAMPP)
$dbname = "organic_food"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
