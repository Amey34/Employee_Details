<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
  header("Location: ../loginh.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <style>
    input,
    select,
    h3 {
      margin-bottom: 1rem;
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-1 p-5" style="width: 70%">
    <h3 class="text-center">ADD DETAILS</h3>
    <form id="formData">
      <label for="emp_id" class="form-label">Enter employee id</label>
      <input type="number" id="emp_id" name="emp_id" class="form-control" required />
      <label for="name_of_detail" class="form-label">Enter name of detail</label>
      <input type="text" id="name_of_detail" name="name_of_detail" class="form-control" required />
      <label for="value_of_detail" class="form-label">Enter value of detail</label>
      <input type="text" id="value_of_detail" name="value_of_detail" class="form-control" required />
      <div>
        <button class="btn" type="submit" id="button1">SUBMIT</button>
      </div>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#formData").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
          url: "../employee_backend/add2.php",
          type: "POST",
          data: $("#formData").serialize(),
          success: function (response) {
            if (response == 1) {
              alert("Data inserted successfully");
              $("#formData")[0].reset();
            } else {
              alert(response);
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