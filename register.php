<?php

session_start();

include('./config/connectDB.php');

if (isset($_POST['signup'])) {

    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    if ($password != $c_password) {
        $_SESSION['message'] = "Passwords dont match";
        header("Location: register.php");
        exit;
    }


    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['message'] = "Name, email or password cant be empty";
        header("Location: register.php");
        exit;
    } else if (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
        $_SESSION['message'] = "Name must only contain letters, hyphens, apostrophe";
        header("Location: register.php");
        exit;
    } else if (strlen($name) < 2 || strlen($name) > 50) {
        $_SESSION['message'] = "Length of name must be between 2 and 50";
        header("Location: register.php");
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format";
        header("Location: register.php");
        exit;
    } else if (strlen($password) < 8) {
        $_SESSION['message'] = "Password must contain at least 8 characters";
        header("Location: register.php");
        exit;
    } else if (!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("[\W]", $password)) {
        $_SESSION['message'] = "Password must contain uppercase letters, lower case letters, digits and special characters";
        header("Location: register.php");
        exit;
    } else {
        $sql = "SELECT * FROM userd WHERE email= '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION['message'] = "User already exists";
            header("Location: register.php");
            exit;
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO userd (name, email,password) VALUES('$name','$email','$password')";
            $result = $conn->query($sql);
            if ($result) {
                $_SESSION['message'] = "User registered successfully!";
                $_SESSION['loggedin'] = true;
                header("location:index.html");
                exit;
            } else {
                echo "<script>alert('User couldnt be registered');</script>" . $conn->error;

            }
        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
    <?php
    if (isset($_SESSION['message'])) {
        $msg = htmlspecialchars($_SESSION['message']);
        echo "<script>alert('$msg');</script>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <form action="register.php" method="post" class="border p-5" style="background-color:black;color:white">
            <h2>Sign Up</h2><br />
            <input type="text" name="name" placeholder="Name"><br /><br />
            <input type="email" name="email" placeholder="Email"><br /><br />
            <input type="password" name="password" placeholder="Password"><br /><br />
            <input type="password" name="c_password" placeholder="Confirm Password"><br /><br />
            <input type="submit" name="signup" value="Sign Up" class="btn btn-primary rounded-pill">
            <h6>Already a user? Please <a href="login.php">Log In</a>
            </h6>
        </form>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                document.querySelector("form").reset();
            }
        });
    </script>
</body>



</html>