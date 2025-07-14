<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include('connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $stmt = $conn->prepare("SELECT 
                                   employee_personal_details.id,
                                   employee_personal_details.name,
                                   employee_personal_details.email,
                                   employee_details.name_of_detail,
                                   employee_details.value_of_detail 
                                   FROM employee_personal_details 
                                   JOIN employee_details 
                                   ON employee_personal_details.id = employee_details.emp_id 
                                   ORDER BY employee_personal_details.id");
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
        <div class='col-1'>{$row['id']}</div>
        <div class='col-3'>{$row['name']}</div>
        <div class='col-3'>{$row['email']}</div>
        <div class='col-2'>{$row['name_of_detail']}</div>
        <div class='col-3'>{$row['value_of_detail']}</div>";
        }
    } else {
        echo "No records found";
    }
}