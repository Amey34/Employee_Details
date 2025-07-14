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
        $stmt = $conn->prepare("SELECT * FROM employee_details WHERE emp_id=? AND name_of_detail=? AND value_of_detail=?");
        $stmt->bind_param("iss", $emp_id, $name_of_detail, $value_of_detail);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("DELETE FROM employee_details WHERE emp_id=? AND name_of_detail=? AND value_of_detail=?");
            $stmt->bind_param("iss", $emp_id, $name_of_detail, $value_of_detail);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Data deleted succesfully";
            } else {
                echo "Could not delete data";
            }
        } else {
            echo "The detail doesnt exist";
        }
    }
}