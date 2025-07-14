<?php

include('connectDB.php');

$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS employee_personal_details (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(50),
                        email VARCHAR(50),
                        mobile_no INT,
                        dob DATE,
                        gender VARCHAR(10),
                        address VARCHAR(100),
                        created_at TIMESTAMP)");
$stmt->execute();
if ($stmt) {
    echo "Created table employee_personal_details";
} else {
    echo "Failed to create table";
}

$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS employee_details (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        emp_id INT,
                        name_of_detail VARCHAR(50),
                        value_of_detail VARCHAR(100),
                        FOREIGN KEY (emp_id) REFERENCES employee_personal_details(id))");
$stmt->execute();
if ($stmt) {
    echo "Created table employee_details";
} else {
    echo "Failed to create table";
}
