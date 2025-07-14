<?php
session_start();
include('./config/connectDB.php');

if (isset($_POST['login'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];



    if (empty($email) || empty($password)) {
        $_SESSION["message"] = "Please provide all fields";
        header("location:login.php");
        exit;
    }
    $sql = "SELECT * FROM userd WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $_SESSION["message"] = "User doesnt exist";
        header("location:login.php");
        exit;
    } else {
        while ($row = $result->fetch_assoc()) {
            if ($email == $row['email']) {
                $p = password_verify($password, $row["password"]);
                break;
            }
        }
        if (!$p) {
            $_SESSION["message"] = "Password is not correct";
            header("location:login.php");
            exit;
        } else {
            $_SESSION["message"] = "Logged in successfully";
            $_SESSION['loggedin'] = true;
            header("location:index.html");
            exit;
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN</title>
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
        <form action="login.php" method="post" class="border p-5" style="background-color:black;color:white">
            <h2>Login</h2><br />
            <input type="email" name="email" placeholder="Email"><br /><br />
            <input type="password" name="password" placeholder="Password"><br /><br />
            <input type="submit" name="login" value="Log In" class="btn btn-primary rounded-pill"><br />
            <p>Not a user? Please <a href="register.php">Sign Up</a></p>
        </form>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                document.querySelector("form").reset();
            }
        });
    </script>
</body>

</html>