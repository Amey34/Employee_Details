<?php
session_start();
include('../config/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];



    if (empty($email) || empty($password)) {
        echo "Please provide all fields";
        exit;
    }
    $sql = "SELECT * FROM admin_details WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "User doesnt exist";
        exit;
    } else {
        while ($row = $result->fetch_assoc()) {
            if ($email == $row['email']) {
                $p = password_verify($password, $row["password"]);
                break;
            }
        }
        if (!$p) {
            echo "Password is not correct";
            exit;
        } else {
            echo "Logged in successfully";
            $_SESSION['loggedin'] = true;
            exit;
        }
    }

}

?>