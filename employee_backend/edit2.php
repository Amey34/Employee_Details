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
    } else {
        $id = trim(filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT));
        $stmt = $conn->prepare("SELECT * FROM employee_details WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $name_of_detail = trim(htmlspecialchars($_POST["name_of_detail"]));
            $value_of_detail = trim(htmlspecialchars($_POST["value_of_detail"]));
            if (empty($value_of_detail) || empty($name_of_detail)) {
                echo "Please provide at least one field to be updated";
                exit;
            } else {
                $stmt = $conn->prepare("SELECT * FROM employee_details WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();

                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $name_of_detail = empty($name_of_detail) ? $row["name_of_detail"] : $name_of_detail;
                $value_of_detail = empty($value_of_detail) ? $row["value_of_detail"] : $value_of_detail;


                $stmt = $conn->prepare("UPDATE employee_details SET name_of_detail=?,value_of_detail=? WHERE id=?");
                $stmt->bind_param("ssi", $name_of_detail, $value_of_detail, $id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo 1;
                } else {
                    echo "Could not update data";
                }
            }
        } else {
            echo "id doesnt exist";
        }

    }

}