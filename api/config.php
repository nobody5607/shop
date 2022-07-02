<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database="shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $database, 3306);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//test
$conn->set_charset("utf8");
