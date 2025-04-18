<?php

  session_start();

  require_once '../database/booking-crud.php';

  $user = new Crud();

  $dep = 'MNL';
  $arr = 'CEB';
  
  $allAvailableDepFlights = $user->searchAvailableFlights($dep, $arr);
  $allAvailableRetFlights = $user->searchAvailableFlights($arr, $dep);

  $selectedDepFlight = null;
  $selectedRetFlight = null;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'next-step' is clicked
      // Save the selected flights into the session for later use
      if (isset($_POST['selected_depflight'])) {
        $_SESSION['selected_depflight'] = $_POST['selected_depflight'];
      }
      if (isset($_POST['selected_retflight'])) {
        $_SESSION['selected_retflight'] = $_POST['selected_retflight'];
      }

      // Set flag to indicate flight selection is complete
      $_SESSION['selectflight_completed'] = true;
      
      // Redirect to guestdetails page after saving selected flights
      header('Location: guestdetails.php');
      exit();


    // Otherwise, save selected flights into the session
    if (isset($_POST['selected_depflight'])) {
        $selectedDepFlight = $_POST['selected_depflight'];
    }

    if (isset($_POST['selected_retflight'])) {
        $selectedRetFlight = $_POST['selected_retflight'];
    }
    
    // Save the selected flights into the session for later use
    $_SESSION['selected_depflight'] = $selectedDepFlight;
    $_SESSION['selected_retflight'] = $selectedRetFlight;
    
    if (!isset($_SESSION['bookingpage_completed'])) {
        header('Location: booking.php');
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

    <!-- SWEET -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>JetSetGo</title>

    <link rel="stylesheet" href="booking-style.css">

    <style>
        .flight-card {
            transition: background-color 0.2s;
            cursor: pointer;
        }
        .flight-card:hover {
            background-color: #f8f9fa;
        }

        .selected-departing-container .flight-card{
          border: 3px solid green;
          background-color: #e6ffe6;
        }

        .selected-returning-container .flight-card{
          border: 3px solid green;
          background-color: #e6ffe6;
        }

        .price {
            color: #4B0082;
            font-weight: bold;
        }
    </style>

        <!-- for debugging  -->
        <script>
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                alert("Error: " + msg + " in " + url + " at line " + lineNo);
                return false;
            };
        </script>
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
        
        <form method="POST" action="#">
            <!-- Departing FLIGHTS CONTAINER -->
            <div class="container departing-container" id="departing-container" style="padding: 20px; max-width: 75%">
                <div class="card border-primary">
                    <div class="card-body" style="padding: 30px;">
                        <h6 class="mb-2">Select your Departing Flight</h6>
                        <h3><strong><?= $dep ?></strong> Cebu - <strong><?= $arr ?></strong> Manila</h3>
                        <p class="text-muted">Filter by:</p>
                          <?php foreach ($allAvailableDepFlights as $u): ?>

                              <?php 
                                $depart = strtotime($u['departure_time']);
                                $arrive = strtotime($u['arrival_time']);
                                $durationMinutes = ($arrive - $depart) / 60;
                                $hours = floor($durationMinutes / 60);
                                $minutes = $durationMinutes % 60;
                                $durationFormatted = "{$hours}h {$minutes}min";
                              ?>

                              <div class="container my-2">
                                <div class="row justify-content-center">
                                  <div class="col-lg-15">
                                    <label class="border rounded flight-card p-3 d-block w-100">
                                      <input type="radio" name="selected_depflight" onclick="handleDepFlightSelection(this)" value="<?= $u['flight_id'] ?>" hidden required>

                                      <div class="row align-items-center">
                                        <!-- Time and route (Departure) -->
                                        <div class="col-md-2 text-center">
                                          <div><strong><?= date("g:i A", strtotime($u['departure_time'])) ?></strong></div>
                                          <div class="text">
                                            Depart - <strong><?= $u['departure_location'] ?></strong>
                                          </div>
                                        </div>

                                        <!-- Time and route (Arrival) -->
                                        <div class="col-md-2 text-center">
                                          <div><strong><?= date("g:i A", strtotime($u['arrival_time'])) ?></strong></div>
                                          <div class="text">
                                            Arrive - <strong><?= $u['arrival_location'] ?></strong>
                                          </div>
                                        </div>

                                        <!-- Plane Code -->
                                        <div class="col-md-3 text-center">
                                          <?= $u['plane_code'] ?>
                                        </div>

                                        <!-- Duration -->
                                        <div class="col-md-2 text-center">
                                          <?= $durationFormatted ?>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-3 text-center">
                                          <span class="price" style="color: red;">PHP <?= number_format($u['price'], 2) ?></span><br>
                                          <small class="text-muted">per Guest</small>
                                        </div>
                                      </div>
                                    </label>
                                  </div>
                                </div>
                              </div>

                          <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- SELECTED Departing FLIGHTS CONTAINER -->
            <div class="container selected-departing-container" id="selected-departing-container" style="padding: 20px; max-width: 75%; display: none">
                <div class="card border-primary">
                    <div class="card-body" style="padding: 30px;">
                        <h6 class="mb-2">Selected Departing Flight</h6>
                        <h3><strong><?= $dep ?></strong> Cebu - <strong><?= $arr ?></strong> Manila</h3>

  
                          <!-- <div class="mt-1 text-end">
                              <button type="button" class="btn btn-primary">Change</button>
                          </div> -->
                    </div>
                </div>
            </div>

            <!-- Returning FLIGHTS CONTAINER -->
            <div class="container returning-container" id="returning-container" style="padding: 20px; max-width: 75%; display: none;">
                <div class="card border-primary">
                    <div class="card-body" style="padding: 30px;">
                        <h6 class="mb-2">Select your Returning Flight</h6>
                        <h3><strong><?= $dep ?></strong> Manila - <strong><?= $arr ?></strong> Cebu</h3>
                        <p class="text-muted">Filter by:</p>
                          <?php foreach ($allAvailableRetFlights as $u): ?>

                              <?php 
                                $depart = strtotime($u['departure_time']);
                                $arrive = strtotime($u['arrival_time']);
                                $durationMinutes = ($arrive - $depart) / 60;
                                $hours = floor($durationMinutes / 60);
                                $minutes = $durationMinutes % 60;
                                $durationFormatted = "{$hours}h {$minutes}min";
                              ?>

                              <div class="container my-2">
                                <div class="row justify-content-center">
                                  <div class="col-lg-15">
                                    <label class="border rounded flight-card p-3 d-block w-100">
                                      <input type="radio" name="selected_retflight" onclick="handleRetFlightSelection(this)" value="<?= $u['flight_id'] ?>" hidden required>

                                      <div class="row align-items-center">
                                        <!-- Time and route (Departure) -->
                                        <div class="col-md-2 text-center">
                                          <div><strong><?= date("g:i A", strtotime($u['departure_time'])) ?></strong></div>
                                          <div class="text">
                                            Depart - <strong><?= $u['departure_location'] ?></strong>
                                          </div>
                                        </div>

                                        <!-- Time and route (Arrival) -->
                                        <div class="col-md-2 text-center">
                                          <div><strong><?= date("g:i A", strtotime($u['arrival_time'])) ?></strong></div>
                                          <div class="text">
                                            Arrive - <strong><?= $u['arrival_location'] ?></strong>
                                          </div>
                                        </div>

                                        <!-- Plane Code -->
                                        <div class="col-md-3 text-center">
                                          <?= $u['plane_code'] ?>
                                        </div>

                                        <!-- Duration -->
                                        <div class="col-md-2 text-center">
                                          <?= $durationFormatted ?>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-3 text-center">
                                          <span class="price" style="color: red;">PHP <?= number_format($u['price'], 2) ?></span><br>
                                          <small class="text-muted">per Guest</small>
                                        </div>
                                      </div>
                                    </label>
                                  </div>
                                </div>
                              </div>

                          <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- SELECTED Returning FLIGHTS CONTAINER -->
            <div class="container selected-returning-container" id="selected-returning-container" style="padding: 20px; max-width: 75%; display: none">
                <div class="card border-primary">
                    <div class="card-body" style="padding: 30px;">
                        <h6 class="mb-2">Selected Returning Flight</h6>
                        <h3><strong><?= $arr ?></strong> Manila - <strong><?= $dep ?></strong> Cebu</h3>

                          <!-- <div class="mt-1 text-end">
                              <button type="button" class="btn btn-primary">Change</button>
                          </div> -->
                    </div>
                </div>
          </div>

              

          <button type="submit" class="btn btn-primary">
              Next
          </button>
        </form>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
      function afterSelectDeparting() {

        document.querySelector('.departing-container').style.display = 'none';
        document.querySelector('.returning-container').style.display = 'block';
        document.querySelector('.selected-departing-container').style.display = 'block';
        document.querySelector('.returning-container').scrollIntoView({ behavior: 'smooth' });
      }



      function handleDepFlightSelection(input) {
        // Uncheck all others to simulate radio button behavior
        const checkboxes = document.querySelectorAll('input[name="selected_depflight"]');
        checkboxes.forEach(cb => {
          if (cb !== input) cb.checked = false;
        });


        input.closest('.flight-card').classList.add('selected');

        // Proceed to returning flight selection if one is selected
        if (input.checked) {
          afterSelectDeparting();

          // SweetAlert2 Toast
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
          });

          Toast.fire({
            icon: 'success',
            title: 'Departing flight selected!'
          });


        }
      }


      function afterSelectReturning() {
        document.querySelector('.departing-container').style.display = 'none';
        document.querySelector('.returning-container').style.display = 'none';
        document.querySelector('.selected-departing-container').style.display = 'block';
        document.querySelector('.selected-returning-container').style.display = 'block';
      }

      
      function handleRetFlightSelection(input) {
        // Uncheck all others to simulate radio button behavior
        const checkboxes = document.querySelectorAll('input[name="selected_retflight"]');
        checkboxes.forEach(cb => {
          if (cb !== input) cb.checked = false;
        });

        input.closest('.flight-card').classList.add('selected');

        // Proceed to returning flight selection if one is selected
        if (input.checked) {
          afterSelectReturning();

          // SweetAlert2 Toast
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
          });

          Toast.fire({
            icon: 'success',
            title: 'Returning flight selected!'
          });
        }
      }
    </script>


    <script src="booking.js"></script>

  </body>
</html>