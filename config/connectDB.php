<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "<script>alert('Error in connection');</script>" . $conn->connect_error;
}