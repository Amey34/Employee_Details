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

    #nameError,
    #mobileError,
    #addressError {
      padding: 0;
      margin: 0;
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-1 p-5" style="width: 70%">
    <h3 class="text-center">ADD DETAILS</h3>
    <form id="formData">
      <label for="name" class="form-label">Enter name</label>
      <input type="text" id="name" name="name" class="form-control" required />
      <label for="email" class="form-label">Enter email</label>
      <input type="email" id="email" name="email" class="form-control" required />
      <label for="mobile_no" class="form-label">Enter mobile number</label>
      <input type="text" id="mobile_no" name="mobile_no" class="form-control" required />

      <label for="dob" class="form-label">Enter date of birth</label>
      <input type="date" id="dob" name="dob" class="form-control" required />
      <div>
        <label for="gender" class="form-label">Enter gender</label>
        <select id="gender" name="gender" class="form-select" required>
          <option value="">Choose</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>
      <label for="address" class="form-label">Enter address</label>
      <input type="text" id="address" name="address" class="form-control" required />

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
        let valid = true;

        const mobile = /^[6-9][0-9]{9}$/;

        if (!mobile.test($("#mobile_no").val())) {
          alert("Invalid mobile number");
          valid = false;
        }

        if ($("#name").val().length < 2 || $("#name").val().length > 50) {
          alert("Name should be between 2 and 50 characters");
          valid = false;
        }

        if ($("#address").val().length > 50) {
          alert("Address should be more than 100 characters");
          valid = false;
        }

        if (valid) {
          $.ajax({
            url: "../employee_backend/add.php",
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
        }
      });
    });
  </script>
</body>

</html>