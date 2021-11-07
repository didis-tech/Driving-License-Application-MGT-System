<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_database = "getlicensed";

// Create connection
$conn = new mysqli($servername,$username,$password,$db_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
