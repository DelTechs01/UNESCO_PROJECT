<?php
$servername = "localhost"; //server name or IP
$username = "root"; //database username
$password = ""; //database password
$dbname = "member_db"; //database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
