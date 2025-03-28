<?php
// This is for the database connection, like a startup
$servername = "localhost";
$username = "root";
$password = "";
$database = "ShoppingDB1"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>