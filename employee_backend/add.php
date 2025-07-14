<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include('../config/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = trim(htmlspecialchars($_POST["name"]));
    $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
    $mobile_no = trim($_POST["mobile_no"]);
    $dob = $_POST["dob"];
    $gender = trim($_POST["gender"]);
    $address = trim(htmlspecialchars($_POST["address"]));
    if (empty($name) || empty($email) || empty($mobile_no) || empty($dob) || empty($gender) || empty($address)) {
        echo "Please provide all fields";
        exit;
    } else {
        $date = new DateTime();
        $dobDate = new DateTime($dob);
        $age = $date->diff($dobDate)->y;
        $gender_types = array("male", "female", "other");

        if (strlen($name) < 2 || strlen($name) > 50) {
            echo "Name should be between 2 and 50 characters";
            exit;
        } else if (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
            echo "Name can only contain letters, hyphen and apostrophe";
            exit;
        } else if (!preg_match("/^[6-9][0-9]{9}$/", $mobile_no)) {
            echo "Enter valid mobile number";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
            exit;
        } else if ($dobDate > $date) {
            echo "Date of birth cant be in the future";
            exit;
        } else if ($age < 18) {
            echo "Age cant be less than 18";
            exit;
        } else if (!in_array($gender, $gender_types)) {
            echo "Enter valid gender";
            exit;
        } else if (strlen($address) > 100) {
            echo "Address should be less than 100 characters";
        } else {
            $stmt = $conn->prepare("SELECT * FROM employee_personal_details WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo "User already exists";
                exit;
            } else {
                $stmt = $conn->prepare("INSERT INTO employee_personal_details (name,email,mobile_no,dob,gender,address) VALUES(?,?,?,?,?,?)");
                $stmt->bind_param("ssssss", $name, $email, $mobile_no, $dob, $gender, $address);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo 1;
                    exit;
                } else {
                    echo "Failed to insert data";
                }
            }
        }
    }
}