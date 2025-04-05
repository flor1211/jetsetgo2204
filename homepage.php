<?php

  session_start();


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_SESSION['homepage'] = true;

      header('Location: booking.php');

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


        <!-- Main Content -->
        <div style="padding: 20px;">
            <h1>JeSetGo</h1>
    

        </div>

        <!-- Main Container -->
        <div>
            <a href="booking/booking.php" class="btn btn-primary">
              Book Now
            </a>
        </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="booking.js"></script>

  </body>
</html>