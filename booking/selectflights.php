<?php

  session_start();

  require_once '../database/booking-crud.php';

  $user = new BookingCrud();


  $dep =  $_SESSION['selected_from'];
  $arr =  $_SESSION['selected_to'];
  $ddate = $_SESSION['departing_date'];
  $rdate = $_SESSION['returning_date'];

  $numadult = (int)$_SESSION['num_of_adult'];
  $numchildren = (int) $_SESSION['num_of_children'];

  $tripType = $_SESSION['trip_type']; 
  
  $allAvailableDepFlights = $user->searchAvailableFlights($dep, $arr, $ddate);
  $allAvailableRetFlights = $user->searchAvailableFlights($arr, $dep, $rdate);

  $selectedDepFlight = null;
  $selectedRetFlight = null;


  

      
  if (!isset($_SESSION['bookingpage_completed'])) {
    header('Location: booking.php');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      // Save the selected flights into the session for later use
      if (isset($_POST['selected_depflight'])) {
        $_SESSION['selected_depflight'] = $_POST['selected_depflight'];
        $selectedDepFlight = $_POST['selected_depflight'];

      }
      if (isset($_POST['selected_retflight'])) {
        $_SESSION['selected_retflight'] = $_POST['selected_retflight'];
        $selectedRetFlight = $_POST['selected_retflight'];
      }

      $_SESSION['numberofpassenger'] = $numadult + $numchildren;

      $_SESSION['depFlightInfo'] = $user->getSelectedFlight($selectedDepFlight);
      $_SESSION['retFlightInfo'] = $_SESSION['trip_type'] === 'roundtrip' ? $user->getSelectedFlight($selectedRetFlight) : 0;


      $_SESSION['departing_price'] = $_SESSION['depFlightInfo'] [0]['price'];
      $_SESSION['returning_price'] = $_SESSION['retFlightInfo'] [0]['price'];



      // Set flag to indicate flight selection is complete
      $_SESSION['selectflight_completed'] = true;
      
      // Redirect to guestdetails page after saving selected flights
      header('Location: guestdetails.php');
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

        @media (max-width:1000px) {
          .bookingselected {
            display: none;
          }
        }

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

        <!-- for debugging  -->
        <script>
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                alert("Error: " + msg + " in " + url + " at line " + lineNo);
                return false;
            };
        </script>

      <script>
            var selectedFrom = "<?php echo isset ($_SESSION['selected_from']) ?
              $_SESSION['selected_from'] : 'No Airport Selected'; ?>";
            var selectedTo = "<?php echo isset ($_SESSION['selected_to']) ?
              $_SESSION['selected_to'] : 'No Airport Selected'; ?>";
            var adultNum = "<?php echo isset ($_SESSION['num_of_adult']) ?
              $_SESSION['num_of_adult'] : 'No Number of Adults was submitted'; ?>";
            var childNum = "<?php echo isset ($_SESSION['num_of_children']) ?
              $_SESSION['num_of_children'] : 'No Number of Children was submitted'; ?>";
            var departingDate = "<?php echo isset ($_SESSION['departing_date']) ?
              $_SESSION['departing_date'] : 'No departing date was submitted'; ?>";
            var returningDate = "<?php echo isset ($_SESSION['returning_date']) ?
              $_SESSION['returning_date'] : 'No return date submitted'; ?>";


            var triptype = "<?php echo isset ($_SESSION['trip_type']) ?
              $_SESSION['trip_type'] : 'Error in trip type submitted'; ?>";


            alert("Selected From Airport: " + selectedFrom + "\nSelected To Airport: " + selectedTo + "\nNumber of Adults: " + adultNum
                  + "\nNumber of Children: " + childNum + "\nDeparting Date: " + departingDate + "\nReturn Date: " + returningDate
                  + "\nTrip Type: " + triptype);
        </script>
  </head>
    <body style="margin: 0;">
         <!-- NavBar Container -->
         <div id="navbar-container">
            <!-- <script>
                fetch("topbar.php")
                  .then(res => res.text())
                  .then(data => {
                    document.getElementById("navbar-container").innerHTML = data;
                  });
              </script> -->
              <nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
                <div class="container-fluid d-flex align-items-center">


                  <span class="navbar-brand">
                    <img src="your-logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-center">
                    JetSetGo
                  </span>

                  <button class="btn btn-outline-light ms-auto" id="cancelBookingBtn">
                    <i class="bi bi-box-arrow-left"></i> Cancel Booking
                  </button>


                </div>
              </nav>
        </div>

        <!-- Main Content -->
        <div class="bookingselected bg-white w-100 shadow rounded overflow-hidden">
          <div>
            <div class="d-flex justify-content-center align-items-center" style="margin: 0; padding: 0px; height: 115px">
              <!-- Flight Info Blocks -->
              <div class="d-flex flex-wrap align-items-top gap-5">

              
                <div class="me-4">
                  <h6 class="mb-2">Departing Flight</h6>
                  <b><?= $dep ?></b><span class="ms-1"></span> to <b class="ms-2"><?= $arr ?></b><span class="ms-1"></span><br>
                  <small> <?= date("d F Y", strtotime($ddate)) ?></small>
                </div>

                <?php if ($tripType === 'roundtrip'): ?>
                <div class="me-4">
                  <h6 class="mb-2">Returning Flight</h6>
                  <b><?= $arr ?></b><span class="ms-1"></span> to <b class="ms-2"><?= $dep ?></b><span class="ms-1"></span><br>
                  <small> <?= date("d F Y", strtotime($rdate)) ?></small>
                </div>
                <?php endif; ?>

                <div class="me-4">
                  <h6 class="mb-2">Guest</h6>
                  <span class="ms-1"><?= $numadult ?> Adult, <?= $numchildren ?> Children</span>
                </div>
              </div>
                <div>
                  <a role="button" href="booking.php" class="btn btn-outline-primary" name="editsearch" >Edit Search</a>
                </div>
            </div>
          </div>
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
        
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="flight-selection-form">

            <!-- Departing FLIGHTS CONTAINER -->
            <div class="container departing-container" id="departing-container" style="padding: 20px; max-width: 75%">
              <div class="card border-primary">
                  <div class="card-body" style="padding: 30px;">
                      <h6 class="mb-2">Select your Departing Flight</h6>
                      <h3><strong><?= $dep ?></strong> - <strong><?= $arr ?></strong></h3>

                      <?php if (empty($allAvailableDepFlights)): ?>
                        <div class="alert alert-warning text-center" style="margin-top: 15px" role="alert">
                          <h4 class="alert-heading">No Flights Available!</h4>
                          <p>Unfortunately, there are no flights from <strong><?= $dep ?></strong> to <strong><?= $arr ?></strong> on your selected date.</p>
                          <a href="booking.php" class="btn btn-primary" style="margin: 0;">Select Another Date</a>
                        </div>
                      
                      <?php else: ?>
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
                                                  <div class="col-md-2 text-center">
                                                      <div><strong><?= date("g:i A", strtotime($u['departure_time'])) ?></strong></div>
                                                      <div class="text">Depart - <strong><?= $u['departure_code'] ?></strong></div>
                                                  </div>

                                                  <div class="col-md-2 text-center">
                                                      <div><strong><?= date("g:i A", strtotime($u['arrival_time'])) ?></strong></div>
                                                      <div class="text">Arrive - <strong><?= $u['arrival_code'] ?></strong></div>
                                                  </div>

                                                  <div class="col-md-3 text-center">
                                                      <?= $u['plane_code'] ?>
                                                  </div>

                                                  <div class="col-md-2 text-center">
                                                      <?= $durationFormatted ?>
                                                  </div>

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
                      <?php endif; ?>
                  </div>
              </div>
            </div>

            <!-- SELECTED Departing FLIGHTS CONTAINER -->
            <div class="container selected-departing-container" id="selected-departing-container" style="padding: 20px; max-width: 75%; display: none">
                <div class="card border-primary">
                  <div class="card-body" style="padding: 30px;">
                        <!-- Title + Button in one row -->
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <h6 class="mb-0">Selected Departing Flight</h6>
                                <h3 class="mt-1"><strong><?= $dep ?></strong> - <strong><?= $arr ?></strong></h3>
                            </div>
                            <div>
                                <button type="button" onclick="changeSelectDepFlight(this)" style="margin: 0;" class="btn btn-outline-success">Change</button>
                            </div>
                        </div>

                        <div id="selected-departing-card-container" class="mt-3"></div>
                    </div>
                </div>
            </div>




            
            <!-- Returning FLIGHTS CONTAINER -->
            <div class="container returning-container" id="returning-container" style="padding: 20px; max-width: 75%; display: none;">
                <div class="card border-primary">
                    <div class="card-body" style="padding: 30px;">
                        <h6 class="mb-2">Select your Returning Flight</h6>

                        <h3><strong><?= $arr ?></strong> - <strong><?= $dep ?></strong></h3>
                          
                        <?php if (empty($allAvailableRetFlights)): ?>
                          <div class="alert alert-warning text-center" style="margin-top: 15px" role="alert">
                            <h4 class="alert-heading">No Flights Available!</h4>
                            <p>Unfortunately, there are no flights from <strong><?= $arr ?></strong> to <strong><?= $dep ?></strong> on your selected date.</p>
                            <a href="booking.php" class="btn btn-primary" style="margin: 0;">Select Another Date</a>
                          </div>
                        <?php else: ?>
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
                                            Depart - <strong><?= $u['departure_code'] ?></strong>
                                          </div>
                                        </div>

                                        <!-- Time and route (Arrival) -->
                                        <div class="col-md-2 text-center">
                                          <div><strong><?= date("g:i A", strtotime($u['arrival_time'])) ?></strong></div>
                                          <div class="text">
                                            Arrive - <strong><?= $u['arrival_code'] ?></strong>
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
                          <?php endif; ?>
                    </div>
                </div>
            </div>


            <!-- SELECTED Returning FLIGHTS CONTAINER -->
            <div class="container selected-returning-container" id="selected-returning-container" style="padding: 20px; max-width: 75%; display: none">
                <div class="card border-primary">
                    <div class="card-body" style="padding: 30px;">

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <h6 class="mb-0">Selected Departing Flight</h6>
                                <h3 class="mt-1"><strong><?= $dep ?></strong> - <strong><?= $arr ?></strong></h3>
                            </div>
                            <div>
                                <button type="button" onclick="changeSelectDepFlight(this)" style="margin: 0;" class="btn btn-outline-success">Change</button>
                            </div>
                        </div>

                        <div id="selected-returning-card-container" class="mt-3"></div>
                    </div>
                </div>
            </div>

            <div class="container d-flex justify-content-end gap-3" style="padding: 0; max-width: 75%;">
              <a class="btn btn-secondary btn-md" href="booking.php" role="button" style="margin: 0; ">BACK</a>
              <button type="submit" class="btn btn-primary btn-md" style="margin: 0;margin-right: 20px">CONTINUE</button>
            </div>





        </form>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>

      function afterSelectDeparting() {
          document.querySelector('.departing-container').style.display = 'none';
          document.querySelector('.selected-departing-container').style.display = 'block';

          if (triptype === 'onewaytrip') {
            // Oneway trip, no returning flight
            document.querySelector('.returning-container').style.display = 'none';
            document.querySelector('.selected-returning-container').style.display = 'none';
          } else {
            // Roundtrip, show returning flight selection
            document.querySelector('.returning-container').style.display = 'block';
            document.querySelector('.returning-container').scrollIntoView({ behavior: 'smooth' });
          }
      }



      function changeSelectDepFlight() {
        document.querySelector('.departing-container').style.display = 'block';
        document.querySelector('.returning-container').style.display = 'none';
        document.querySelector('.selected-departing-container').style.display = 'none';
        document.querySelector('.selected-returning-container').style.display = 'none';

      }


      function handleDepFlightSelection(input) {
        // Uncheck all others
        const checkboxes = document.querySelectorAll('input[name="selected_depflight"]');
        checkboxes.forEach(cb => {
          cb.closest('.flight-card').classList.remove('selected');
          if (cb !== input) cb.checked = false;
        });

        input.closest('.flight-card').classList.add('selected');

        if (input.checked) {
          afterSelectDeparting();

          // Show toast
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
          });
          Toast.fire({
            icon: 'success',
            title: 'Departing flight selected!',
          });

          // Display selected flight in selected-departing-container
          const selectedCard = input.closest('.flight-card').cloneNode(true);
          selectedCard.classList.add('border', 'border-success');

          selectedCard.querySelector('input').remove(); // remove the input from cloned card

          const targetContainer = document.getElementById('selected-departing-card-container');
          targetContainer.innerHTML = ''; // Clear previous selection
          targetContainer.appendChild(selectedCard);
        }
      }

      function afterSelectReturning() {
        document.querySelector('.departing-container').style.display = 'none';
        document.querySelector('.returning-container').style.display = 'none';
        document.querySelector('.selected-departing-container').style.display = 'block';
        document.querySelector('.selected-returning-container').style.display = 'block';
      }

      function changeSelectRetFlight() {

        document.querySelector('.departing-container').style.display = 'none';
        document.querySelector('.returning-container').style.display = 'block';
        document.querySelector('.selected-departing-container').style.display = 'block';
        document.querySelector('.selected-returning-container').style.display = 'none';
          
        // Uncheck any selected return flight
        const returnRadios = document.querySelectorAll('input[name="selected_retflight"]');
        returnRadios.forEach(r => r.checked = false);

        // Clear the selected card
        document.getElementById('selected-returning-card-container').innerHTML = '';

      }


      function handleRetFlightSelection(input) {
        // Uncheck all others
        const checkboxes = document.querySelectorAll('input[name="selected_retflight"]');
        checkboxes.forEach(cb => {
          cb.closest('.flight-card').classList.remove('selected');
          if (cb !== input) cb.checked = false;
        });

        input.closest('.flight-card').classList.add('selected');

        if (input.checked) {
          afterSelectReturning();

          // Show toast
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
          });
          Toast.fire({
            icon: 'success',
            title: 'Returning flight selected!',
          });

          // Display selected flight in selected-departing-container
          const selectedCard = input.closest('.flight-card').cloneNode(true);
          selectedCard.classList.add('border', 'border-success');

          selectedCard.querySelector('input').remove(); // remove the input from cloned card

          const targetContainer = document.getElementById('selected-returning-card-container');
          targetContainer.innerHTML = ''; // Clear previous selection
          targetContainer.appendChild(selectedCard);
        }
      }
      



    </script>


  <script>
    document.getElementById('cancelBookingBtn').addEventListener('click', function () {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will cancel your booking and cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Cancel Booking',
        cancelButtonText: 'Back'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'cancelbooking.php';
        }
      });
    });
  </script>
      

  </body>
</html>