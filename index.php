<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
  header("Location: loginh.php");
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
    .card {
      border: 1px solid #00203fff;
    }

    .card-body {
      background-color: #00203fff;
    }

    .card-body div {
      width: 100%;
      height: 25%;
      font-size: 1.5rem;
      color: #00203fff;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #adefd1ff;
      border: 1px solid #00203fff;
    }

    .card-header {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 12%;
      width: 100%;
      font-size: 1.8rem;
      background-color: #00203fff;

      color: #adefd1ff;
    }

    #container {
      background-color: #adefd1ff;
    }

    .card-body a {
      text-decoration: none;
    }

    #logout {
      border: 1px solid;
      background-color: #00203fff;
      margin: 0.3rem;
    }
  </style>
</head>

<body>
  <div class="container-fluid" id="container" style="height: 100vh; margin: 0; padding: 0">
    <div class="d-flex w-100">

      <div class="ms-auto"><button id="logout" class="btn"><a href="authentication/logout.php"
            style="text-decoration:none;color:#adefd1ff">LOG
            OUT</a></button></div>
    </div>

    <div class="row border" style="height: 93%; margin: 0; padding: 0">
      <div class="col-6" style="padding: 0 0.5rem 0 0">
        <div class="card" style="height: 100%">
          <div class="card-header">EMPLOYEE PERSONAL DETAILS</div>
          <div class="card-body">
            <a href="./employee_frontend/addDetails.php">
              <div>
                ADD <span><i class="bi bi-plus-circle"></i></span>
              </div>
            </a>
            <a href="./employee_frontend/editDetails.php">
              <div>
                UPDATE <span><i class="bi bi-pencil-square"></i> </span>
              </div>
            </a>
            <a href="./employee_frontend/delete.php">
              <div>
                DELETE <span><i class="bi bi-trash"></i></span>
              </div>
            </a>
            <a href="./employee_frontend/display.php">
              <div>
                DISPLAY <span><i class="bi bi-eye"></i></span>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="col-6" style="padding: 0">
        <div class="card" style="height: 100%">
          <div class="card-header">EMPLOYEE ADDITIONAL DETAILS</div>
          <div class="card-body">
            <a href="./employee_frontend/add2.php">
              <div>
                ADD <span><i class="bi bi-plus-circle"></i></span>
              </div>
            </a>
            <a href="./employee_frontend/edit2.php">
              <div>
                UPDATE <span><i class="bi bi-pencil-square"></i> </span>
              </div>
            </a>
            <a href="./employee_frontend/delete2.php">
              <div>
                DELETE <span><i class="bi bi-trash"></i></span>
              </div>
            </a>
            <a href="./employee_frontend/display2.php">
              <div>
                DISPLAY <span><i class="bi bi-eye"></i></span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>