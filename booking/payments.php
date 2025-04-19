<?php

  session_start();

  if (!isset($_SESSION['addons_completed'])) {
    header('Location: addons.php');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_SESSION['payments_completed'] = true;
      header('Location: confirmation.php');
      exit();
  }


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

  </head>
    <body style="margin: 0;">
         <!-- NavBar Container -->
         <div id="navbar-container">
            <script>
                fetch("topbar.php")
                  .then(res => res.text())
                  .then(data => {
                    document.getElementById("navbar-container").innerHTML = data;
                  });
              </script>
        </div>

        

        <!-- Main Content -->
        <div style="padding: 20px;">
            <h1>JeSetGo</h1>
    

        </div>


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

      
        <!-- HERE KA MAGSTART -->
        <div class="container my-4 d-flex justify-content-center">
          <div class="w-100" style="max-width: 800px;">

            <h3 style="font-weight: 700;">Booking Summary</h3>
            <h6>Review your booking before proceeding to payment</h6>

            <!-- Booking -->
            <div class="bg-white shadow rounded mb-4 overflow-hidden">
              <div class="p-4">
                <div class="mb-3">
                  <b>CEB</b> Cebu to <b>MNL</b> Manila<br>
                  <small>04 January 2025 | 10:00 AM - 12:00 PM</small>
                </div>
                <hr>

                <div class="d-flex justify-content-between mb-3 ms-5">
                  <span>Adult 1</span>
                  <span class="me-5"><b>PHP 4,000.00</b></span>
                </div>

                <div class="d-flex justify-content-between mb-1 ms-5">
                  <span>Taxes and Fees</span>
                  <span class="me-5"><b>PHP 1,088.00</b></span>
              </div>
            </div>

              <div class="d-flex justify-content-between fw-bold px-4 py-2" style="background-color:rgb(154, 167, 231); color: #000;">
                <span class="ms-5">Total</span>
                <span class="me-5">PHP 5,088.00</span>
              </div>
          </div>


            <!-- Payment -->

          <h3 style="font-weight: 700; padding-top: 25px;">Payment Method </h3>
          <h6>Review your booking before proceeding to payment</h6>

          <div class="p-4 bg-white shadow rounded" style="height: 250px">
              <h4>Hello</h4>
              <p></p>
          </div>

            <!-- TERMS AND CONDITIONS -->
            <div class="white shadow border rounded p-2 bg-white mb-3" style="margin-top: 30px;">
              <div style="display: flex; align-items: flex-start;  padding: 10px;">
                <input type="checkbox" id="IAgree" style="margin-top: 7px; margin-right: 5px;" required>
                <label for="IAgree" style="padding-left: 5px;">
                  By clicking the check box, I confirm that I have read, understand, and accept the Booking Conditions & Airline Policy.
                </label>
              </div>
            </div>

            <!-- BUTTONS -->
            <div class="d-flex justify-content-end align-items-end w-100" style="height: 100px;">
                  <a href="addons.php" class="btn btn-secondary me-3" style="width: 150px; height: 40px;">Back</a>
                  <button type="submit" class="btn btn-primary" style="width: 150px; height: 40px;">Confirm</button>
          </div>

          </div>
        </div>

        


        <!-- Main Container -->
        <form method="POST" action="">

            <button type="submit" class="btn btn-primary">
                Next
            </button>
        </form>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="booking.js"></script>

  </body>
</html>