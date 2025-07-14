<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include('../config/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $sort = "";
    if (!empty($_GET['sort'])) {
        $sort = $_GET['sort'];
    } else {
        $sort = "id";
    }
    $stmt = $conn->prepare("SELECT * FROM employee_personal_details ORDER BY $sort ");
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
        <div class='col-1'>{$row['id']}</div>
        <div class='col-2'>{$row['name']}</div>
        <div class='col-2'>{$row['email']}</div>
        <div class='col-1'>{$row['mobile_no']}</div>
        <div class='col-1'>{$row['dob']}</div>
        <div class='col-1'>{$row['gender']}</div>
        <div class='col-3'>{$row['address']}</div>
        <div class='col-1'>{$row['created_at']}</div>";
        }
    } else {
        echo "No records found";
    }
}