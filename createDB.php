<?php


$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    echo "<script>alert('Error in connection');</script>" . $conn->connect_error;
} else {
    echo "<script>alert('Connection succesfull');</script>";
}

$stmt = $conn->prepare("CREATE DATABASE IF NOT EXISTS employee");
$stmt->execute();

if ($stmt) {
    echo "Created database";
} else {
    echo "Failed to create database";
}



