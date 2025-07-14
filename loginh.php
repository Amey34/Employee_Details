<?php

session_start();

$_SESSION["loggedin"] = "false";

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOG IN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <form id="formData" class="border p-5" style="background-color: black; color: white">
      <h2>Login</h2>
      <br />
      <input type="email" name="email" placeholder="Email" /><br /><br />
      <input type="password" name="password" placeholder="Password" /><br /><br />
      <button type="submit" name="login" value="Log In" class="btn btn-primary rounded-pill">
        LOGIN</button><br />
      <p>Not a user? Please <a href="registerh.php">Sign Up</a></p>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      window.addEventListener("pageshow", function (event) {
        if (
          event.persisted ||
          performance.getEntriesByType("navigation")[0].type ===
          "back_forward"
        ) {
          document.querySelector("form").reset();
        }
      });

      $("#formData").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
          url: "authentication/login.php",
          type: "POST",
          data: $("#formData").serialize(),
          success: function (response) {
            alert(response);
            if (response.trim() == "Logged in successfully") {
              window.location.href = "index.php";
            }
          },
          error: function (response) {
            alert(response);
          },
        });
      });
    });
  </script>
</body>

</html>