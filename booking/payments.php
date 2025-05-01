<?php

  session_start();

  require_once '../database/admin-crud.php';

  require_once '../database/booking-crud.php';

  if (!isset($_SESSION['addons_completed'])) {
    header('Location: addons.php');
    exit();
  }

  $selectedDepFlight = $_SESSION['selected_depflight'] ?? null;
  $selectedRetFlight = $_SESSION['selected_retflight'] ?? null;
  $numberofPassenger = $_SESSION['numberofpassenger'];

  $flightType = $_SESSION['trip_type'];

  $guestDetails = $_SESSION['guest_details'] ?? [];
  
  $user = new Crud();
  $bookingUser = new BookingCrud();


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['confirmbooking'])){

      $depFlightInfo = $bookingUser->getSelectedFlight($selectedDepFlight);
      $retFlightInfo = $bookingUser->getSelectedFlight($selectedRetFlight);
      $depFlight = $depFlightInfo[0];
      $retFlight = $retFlightInfo[0];

      if ($flightType == 'roundtrip') {

        //condition for DEPARTING ONLY
        // echo "<h3>Departure Flight Info:</h3><pre>";
        // print_r($depFlight);
        // echo "</pre>";

        $DEPbookingID = $bookingUser->newBooking($depFlight['flight_id'], $depFlight['date'], $depFlight['departure_time'], $depFlight['departure_code'], $depFlight['departure_location'], $depFlight['arrival_time'], $depFlight['arrival_code'], $depFlight['arrival_location'], $depFlight['plane_code'], $depFlight['plane_photo'], $depFlight['price']);
        $fullDate = $guest['year'] . "-" . $guest['month'] . "-" . $guest['day'];

        foreach ($guestDetails as $guest) {
            // echo "<h3>Guest Details</h3><pre>";
            // print_r($guest);
            // echo "</pre>";
            $bookingUser->addGuestDetails($DEPbookingID, $guest['title'], $guest['first_name'], $guest['last_name'], $fullDate,  $guest['contact'], $guest['nationality'], $guest['email']);
        }

        //condition for RETURNING ONLY
        // echo "<h3>Return Flight Info:</h3><pre>";
        // print_r($retFlight);
        // echo "</pre>";

        $RETbookingID = $bookingUser->newBooking($retFlight['flight_id'], $retFlight['date'], $retFlight['departure_time'], $retFlight['departure_code'], $retFlight['departure_location'], $retFlight['arrival_time'], $retFlight['arrival_code'], $retFlight['arrival_location'], $retFlight['plane_code'], $retFlight['plane_photo'], $retFlight['price']);
        $fullDate = $guest['year'] . "-" . $guest['month'] . "-" . $guest['day'];


        foreach ($guestDetails as $guest) {
            // echo "<h3>Guest Details</h3><pre>";
            // print_r($guest);
            // echo "</pre>";

          $bookingUser->addGuestDetails($RETbookingID, $guest['title'], $guest['first_name'], $guest['last_name'], $fullDate, $guest['contact'], $guest['nationality'], $guest['email']);
        }
      

      } else if ($flightType == 'onewaytrip') {

        $DEPbookingID = $bookingUser->newBooking($depFlight['flight_id'], $depFlight['date'], $depFlight['departure_time'], $depFlight['departure_code'], $depFlight['departure_location'], $depFlight['arrival_time'], $depFlight['arrival_code'], $depFlight['arrival_location'], $depFlight['plane_code'], $depFlight['plane_photo'], $depFlight['price']);
      
        foreach ($guestDetails as $guest) {
            // echo "<h3>Guest Details</h3><pre>";
            // print_r($guest);
            // echo "</pre>";
            $bookingUser->addGuestDetails($DEPbookingID, $guest['title'], $guest['first_name'], $guest['last_name'], $guest['year'].$guest['month'].$guest['day'], $guest['contact'], $guest['nationality'], $guest['email']);
        }

      }

      $_SESSION['payments_completed'] = true;
      header('Location: confirmation.php');

      exit();
     
    }

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

        <!-- Main Container -->
        <form method="POST" action="">

        
      <!-- Displaying Guest Details -->
      <!-- <div class="container">
          <h2>Guest Details</h2>
          </?php if (!empty($guestDetails)): ?>
              </?php foreach ($guestDetails as $index => $guest): ?>
                  <div class="guest-details">
                      <h4>Guest #</?= $index ?></h4>
                      <p><strong>Title:</strong> </?= htmlspecialchars($guest['title']) ?></p>
                      <p><strong>First Name:</strong> </?= htmlspecialchars($guest['first_name']) ?></p>
                      <p><strong>Last Name:</strong> </?= htmlspecialchars($guest['last_name']) ?></p>
                      <p><strong>Date of Birth:</strong> </?= htmlspecialchars($guest['year']) ?>-</?= htmlspecialchars($guest['month']) ?>-</?= htmlspecialchars($guest['day']) ?></p>
                      <p><strong>Contact:</strong> </?= htmlspecialchars($guest['contact']) ?></p>
                      <p><strong>Nationality:</strong> </?= htmlspecialchars($guest['nationality']) ?></p>
                      <p><strong>Email:</strong> </?= htmlspecialchars($guest['email']) ?></p>
                  </div>
                  <hr>
              </?php endforeach; ?>
          </?php else: ?>
              <p>No guest details available.</p>
          </?php endif; ?>
      </div> -->

            <button type="submit" name="confirmbooking" class="btn btn-primary">
                Next
            </button>
        </form>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="booking.js"></script>

  </body>
</html>