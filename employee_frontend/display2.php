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
  <style>
    .row {
      margin: 0;
    }

    .row>div {
      border: 1px solid black;
      padding: 0.5rem;
    }

    #row1 {
      background-color: #00203fff;
      color: #adefd1ff;
      font-size: medium;
    }

    #row2 {
      color: #00203fff;
      background-color: #adefd1ff;
    }

    .row div {
      white-space: normal;
      overflow-wrap: break-word;
      word-break: break-word;
    }

    #filter {
      margin: 0.5rem 0 1rem 0;
    }

    .form-select {
      background-color: #adefd1ff;
      color: #00203fff;
      width: 11rem;
      border: 1px solid #00203fff;
    }

    .form-control {
      width: 14rem;
    }

    .form-control::placeholder {
      color: #00203fff;
    }

    #search {
      background-color: #adefd1ff;
      border: 1px solid #00203fff;
    }

    .row div {
      white-space: normal;
      overflow-wrap: break-word;
      word-break: break-word;
    }
  </style>
</head>

<body>
  <div class="d-flex justify-content-end gap-2 px-3" id="filter">
    <select class="form-select" id="category" name="category">
      <option value="">Select Category</option>
      <option value="id">id</option>
      <option value="emp_id">employee id</option>
      <option value="name_of_detail">name of the detail</option>
      <option value="value_of_detail">value of the detail</option>
    </select>
    <input id="search" name="search" placeholder="Enter Value" class="form-control" />
  </div>
  <div class="container-fluid">
    <div class="row" id="row1">
      <div class="col-1">ID</div>
      <div class="col-1">Employee ID</div>
      <div class="col-5">Name of the detail</div>
      <div class="col-5">Value of the detail</div>
    </div>
    <div class="row" id="row2"></div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      $.ajax({
        url: "../employee_backend/display2.php",
        type: "GET",
        success: function (response) {
          $("#row2").html(response);
        },
        error: function (response) {
          alert(response);
        },
      });

      $("#search").keyup(function () {
        let q = $(this).val();
        let p = $("#category").val();
        if (q === "") {
          $.ajax({
            url: "../employee_backend/display2.php",
            type: "GET",
            success: function (response) {
              $("#row2").html(response);
            },
            error: function (response) {
              alert(response);
            },
          });
        } else {
          $.ajax({
            url: "../employee_backend/search2.php",
            type: "POST",
            data: { value: q, cvalue: p },
            success: function (response) {
              $("#row2").html(response);
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