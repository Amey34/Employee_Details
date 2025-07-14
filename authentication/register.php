<?php

session_start();

include('../config/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    if ($password != $c_password) {
        echo "Passwords dont match";
        exit;
    }


    if (empty($name) || empty($email) || empty($password)) {
        echo "Name, email or password cant be empty";
        exit;
    } else if (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
        echo "Name must only contain letters, hyphens, apostrophe";
        exit;
    } else if (strlen($name) < 2 || strlen($name) > 50) {
        echo "Length of name must be between 2 and 50";
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    } else if (strlen($password) < 8) {
        echo "Password must contain at least 8 characters";
        exit;
    } else if (!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("[\W]", $password)) {
        echo "Password must contain uppercase letters, lower case letters, digits and special characters";
        exit;
    } else {
        $sql = "SELECT * FROM admin_details WHERE email= '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "User already exists";
            exit;
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin_details (name, email,password) VALUES('$name','$email','$password')";
            $result = $conn->query($sql);
            if ($result) {
                echo "User registered successfully!";
                $_SESSION['loggedin'] = true;
                exit;
            } else {
                echo "User couldnt be registered";
                exit;
            }
        }

    }

}

?>