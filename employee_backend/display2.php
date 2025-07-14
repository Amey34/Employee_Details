<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include('../config/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $stmt = $conn->prepare("SELECT * FROM employee_details");
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
        <div class='col-1'>{$row['id']}</div>
        <div class='col-1'>{$row['emp_id']}</div>
        <div class='col-5'>{$row['name_of_detail']}</div>
        <div class='col-5'>{$row['value_of_detail']}</div>";
        }
    } else {
        echo "No records found";
    }
}