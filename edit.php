<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include('connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST["id"])) {
        echo "Please enter id";
        exit;
    } else {
        $id = trim(filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT));
        $stmt = $conn->prepare("SELECT * FROM employee_personal_details WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!($result->num_rows > 0)) {
            echo "ID doesnt exist";
            exit;
        } else {
            $row = $result->fetch_assoc();
            $gender = empty($_POST["gender"]) ? $row["gender"] : $_POST["gender"];
            $name = trim(htmlspecialchars($_POST["name"]));
            $email = trim(filter_var($_POST["email"], FILTER_SANITIZE_EMAIL));
            $mobile_no = trim($_POST["mobile_no"]);
            $dob = $_POST["dob"];
            $address = trim(htmlspecialchars($_POST["address"]));
            if (empty($name) && empty($email) && empty($mobile_no) && empty($dob) && empty($address)) {
                echo "Please enter at least one field to be updated";
                exit;
            } else {

                $date = new DateTime();
                if (!empty($dob)) {
                    $dobDate = new DateTime($dob);
                    $age = $date->diff($dobDate)->y;
                }

                $gender_types = array("male", "female", "other");

                if (!empty($name) && (strlen($name) < 2 || strlen($name) > 50)) {
                    echo "Name should be between 2 and 50 characters";
                    exit;
                } else if (!empty($name) && (!preg_match("/^[a-zA-Z-' ]+$/", $name))) {
                    echo "Name can only contain letters, hyphen and apostrophe";
                    exit;
                } else if (!empty($mobile_no) && (!preg_match("/^[6-9][0-9]{9}$/", $mobile_no))) {
                    echo "Enter valid mobile number";
                } else if (!empty($email) && (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
                    echo "Invalid email format";
                    exit;
                } else if (!empty($dob) && ($dobDate > $date)) {
                    echo "Date of birth cant be in the future";
                    exit;
                } else if (!empty($dob) && ($age < 18)) {
                    echo "Age cant be less than 18";
                    exit;
                } else if (!in_array($gender, $gender_types)) {
                    echo "Enter valid gender";
                    exit;
                } else if (!empty($address) && ((strlen($address) > 100))) {
                    echo "Address should be less than 100 characters";
                } else {
                    $name = empty($name) ? $row["name"] : $name;
                    $email = empty($email) ? $row["email"] : $email;
                    $mobile_no = empty($mobile_no) ? $row["mobile_no"] : $mobile_no;
                    $dob = empty($dob) ? $row["dob"] : $dob;
                    $address = empty($address) ? $row["address"] : $address;
                    $stmt = $conn->prepare("UPDATE employee_personal_details SET name=?, email=?, mobile_no=?, dob=?, gender=?, address=? WHERE id=?");
                    $stmt->bind_param("ssssssi", $name, $email, $mobile_no, $dob, $gender, $address, $id);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo 1;
                        exit;
                    } else {
                        echo "Failed to update data";
                    }

                }

            }
        }

    }

}