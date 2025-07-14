<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: ../loginh.php");
    exit;
}

include('../config/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST["id"])) {
        echo "Please enter id";
        exit;
    } else {
        $id = trim(filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT));
        $stmt = $conn->prepare("DELETE FROM employee_personal_details WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Data deleted successfully";
        } else {
            echo "Id doesnt exist";
        }
    }
}