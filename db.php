<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comentarios";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input to prevent SQL Injection
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}
?>
