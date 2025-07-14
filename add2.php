<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include('connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $emp_id = trim(filter_var($_POST["emp_id"], FILTER_SANITIZE_NUMBER_INT));
    $name_of_detail = trim(htmlspecialchars($_POST["name_of_detail"]));
    $value_of_detail = trim(htmlspecialchars($_POST["value_of_detail"]));
    if (empty($emp_id) || empty($name_of_detail) || empty($value_of_detail)) {
        echo "Please provide all fields";
        exit;
    } else {
        $stmt = $conn->prepare("SELECT * FROM employee_personal_details WHERE id=?");
        $stmt->bind_param("i", $emp_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("INSERT INTO employee_details (emp_id, name_of_detail, value_of_detail) VALUES(?,?,?)");
            $stmt->bind_param("iss", $emp_id, $name_of_detail, $value_of_detail);
            $stmt->execute();

            if ($stmt) {
                echo 1;
                exit;
            } else {
                echo "Could not insert data";
                exit;
            }
        } else {
            echo "Employee doesnt exist";
            exit;
        }
    }
}