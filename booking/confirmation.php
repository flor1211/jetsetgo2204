<?php

  session_start();

  if (!isset($_SESSION['payments_completed'])) {
    header('Location: payments.php');
    exit();
  } 

  session_unset();
  session_destroy();
  
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstap S icons CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>JetSetGo</title>

    <link rel="stylesheet" href="booking-style.css">

    <style>
        .navbar {
        height: 55px;
        padding: 0; 
        }

        .custom-navbar {
            background-color: #162447;
        }

        .navbar-brand {
            margin-left: 50px;
            color: white;
            white-space: nowrap; 
        }

        .btn {
            margin: 50px;
        }

        .container-fluid {
            display: flex;
            justify-content: space-between; 
            align-items: center; 
            width: 100%;
        }
    </style>

  </head>
    <body style="margin: 0; background: white">
         <!-- NavBar Container -->
         <div id="navbar-container">
              <nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
                <div class="container-fluid d-flex align-items-center">


                  <span class="navbar-brand">
                    <img src="../assets/logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-center">
                    JetSetGo
                  </span>
                </div>
              </nav>
        </div>

        <br>

        <!-- Steps Container -->
        <div id="steps-container">
            <script>
                const currentPage = location.pathname.split("/").pop();
                fetch("stepsbar.php?page=" + currentPage)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("steps-container").innerHTML = data;
                    });
            </script>
        </div>

        
        <!-- Main Container -->
        <div>
          <div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
            <div class="text-center">
            <img src="assets/check.png" alt="check icon" class="img-fluid mb-4" style="max-width: 150px; padding-top:50px;">
              <h2 class="fw-bold">Thank you for choosing JetSetGo!</h2>
              <p class="mb-1">You'll receive a copy of your booking receipt on your email address. Have a safe flight!</p>
              <a href="../homepage.php" class="btn btn-primary">
                <i class="bi bi-airplane"></i> Back to Home
              </a>
            </div>
          </div>
        </div>



    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="booking.js"></script>

  </body>
</html>
