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
    if (empty($emp_id) || empty($name_of_detail)) {
        echo "Please provide employee id and name of detail";
        exit;
    } else {
        $stmt = $conn->prepare("SELECT * FROM employee_details WHERE emp_id=? AND name_of_detail=?");
        $stmt->bind_param("is", $emp_id, $name_of_detail);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE employee_details SET value_of_detail=? WHERE emp_id=? AND name_of_detail=?");
            $stmt->bind_param("sis", $value_of_detail, $emp_id, $name_of_detail);
            $stmt->execute();

            if ($stmt) {
                echo 1;
                exit;
            } else {
                echo "Could not update data";
                exit;
            }
        } else {
            echo "Either employee doesnt exist or name of detail doesnt exist";
            exit;
        }
    }
}