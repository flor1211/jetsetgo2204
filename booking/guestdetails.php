<?php

  session_start();

  if (!isset($_SESSION['selectflight_completed'])) {
    header('Location: selectflights.php');
    exit();
  }

  require_once '../database/booking-crud.php';

  $user = new BookingCrud();

  $selectedDepFlight = $_SESSION['selected_depflight'] ?? null;
  $selectedRetFlight = $_SESSION['selected_retflight'] ?? null;

  
  $dep =  $_SESSION['selected_from'];
  $arr =  $_SESSION['selected_to'];
  $ddate = $_SESSION['departing_date'];
  $rdate = $_SESSION['returning_date'];

  $numadult = (int)$_SESSION['num_of_adult'];
  $numchildren = (int) $_SESSION['num_of_children'];

  $tripType = $_SESSION['trip_type']; 

  $numberofPassenger = $_SESSION['numberofpassenger'] ?? 1;

//   $depFlightInfo = $user->getSelectedFlight($selectedDepFlight);
//   $retFlightInfo = $_SESSION['trip_type'] === 'roundtrip' ? $user->getSelectedFlight($selectedRetFlight) : 0;

//   $_SESSION['departing_price'] = $depFlightInfo['price'];
//   $_SESSION['returning_price'] = $retFlightInfo['price'];


  $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $guestDetails = $_POST['guests'] ?? [];

        // Validate inputs
        foreach ($guestDetails as $index => $guest) {
            if (empty($guest['title']) || empty($guest['first_name']) || empty($guest['last_name']) ||
                empty($guest['year']) || empty($guest['month']) || empty($guest['day']) ||
                empty($guest['contact']) || empty($guest['nationality']) || empty($guest['email'])) {
                $errors[] = "Please fill in all required fields for guest #$index.";
            }

            if (!filter_var($guest['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format for guest #$index.";
            }

            if ($guest['email'] !== ($guest['retyped_email'] ?? '')) {
                $errors[] = "Emails do not match for guest #$index.";
            }
        }

        if (empty($errors)) {
            $_SESSION['guest_details'] = $guestDetails;
            $_SESSION['guestdetails_completed'] = true;

            // echo '<pre>';
            // print_r($guestDetails); 
            // echo '</pre>';
            header('Location: payments.php');
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

    <!-- <link href="https://fonts.googleapis.com/css2?family=Jaldi&display=swap" rel="stylesheet"> -->

    <title>JetSetGo</title>

    <!-- <link rel="stylesheet" href="booking-style.css"> -->
         <!-- SWEET -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        .div-title {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin: 30px 10%;
        padding: 0;
        margin-bottom: 0;
        }

        .div-title p {
        font-size: 16px;
        color: black;
        margin-bottom: 10px;
        margin-top: 0;
        }

        .div-title h2 {
        font-size: 28px;
        color: #162447;
        font-weight: bold;
        margin-bottom: 20px;
        }

        .details-form {
        display: flex;
        flex-direction: column;
        gap: 20px; /* This will add a gap between the guest forms */
        }

        .details-parent {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-template-rows: auto;
        column-gap: 50px;
        row-gap: 0;
        border: 2px solid rgb(1, 0, 68);
       

        background-color:rgb(247, 247, 247);
        padding: 30px;

        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 80%;
        margin: 0 auto;
        }

        .form-field {
        flex: 1;
        display: flex;
        flex-direction: column;
        width: 100%;        
        }

        .form-field label {
        margin-bottom: 10px;
        font-size: 15px;
        font-weight: bold;
        }

        .form-field input,
        .form-field select {
        margin-bottom: 10px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        background-color:rgb(255, 255, 255);
        }

        .div1 {
        grid-column: span 6 / span 6;
        }

        .div2 {
        grid-column: span 3 / span 3;
        grid-row-start: 2;
        }

        .name-section {
        display: flex;
        gap: 10px;
        width: 100%;
        }

        .name-section .form-field {
        flex: 1;
        display: flex;
        flex-direction: column;
        }

        .form-field select#titleinput {
        width: 100px;
        }

        .div3 {
        grid-column: span 3 / span 3;
        grid-column-start: 4;
        grid-row-start: 2;
        }

        .dob-section {
        display: flex;
        gap: 10px;
        }

        .dob-select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #d9d9d9;
        font-size: 14px;
        }

        .dob-section .form-field {
        flex: 1;
        display: flex;
        flex-direction: column;
        }

        .dob-section select {
        padding: 6px 8px;
        font-size: 14px;
        width: 100%;
        box-sizing: border-box;
        }

        .div4 {
        grid-column: span 3 / span 3;
        grid-row-start: 3;
        }

        .div5 {
        grid-column: span 3 / span 3;
        grid-column-start: 4;
        grid-row-start: 3;
        }

        .div6 {
        grid-column: span 3 / span 3;
        grid-row-start: 4;
        }

        .div7 {
        grid-column: span 3 / span 3;
        grid-column-start: 4;
        grid-row-start: 4;
        }

        @media (max-width: 768px) {
        .details-parent {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .name-section,
        .dob-section {
            flex-direction: column;
        }

        .form-field select#titleinput {
            width: 100%;
            min-width: 300px;  
        }

        .div2, .div3, .div4, .div5, .div6, .div7 {
            grid-column: span 6 / span 6 !important;
            grid-column-start: auto !important;
            grid-row-start: auto !important;
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
            <div class="d-flex justify-content-center align-items-center" style="margin: 0; padding: 0px; height: 105px">
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

        <div class="container">
          <div class="div-title">
              <p>Now that you've selected your flight, enter your details.</p>
              <h2>Guest Details</h2>
          </div>
        </div>



        <!-- CONTAINER FOR GUEST DETAILS -->
    <form method="POST" action="">
        <div class="details-form" id="detailsFormContainer">
            <?php
            for ($i = 1; $i <= $numberofPassenger; $i++): 
            ?>
            <div class="details-parent" id="guest<?= $i ?>">
                <div class="div1">
                <h2 class="guest-title">Passenger <?= $i ?></h2>
                </div>

                <div class="div2">
                <h4>Name</h4>
                <div class="row name-section">
                    <div class="form-field col-md-4 col-sm-12">
                    <label for="titleinput<?= $i ?>">Title</label>
                    <select class="form-control" id="titleinput<?= $i ?>" name="guests[<?= $i ?>][title]" required>
                        <option value="" disabled selected></option>
                        <option value="Mr.">Mr.</option>
                        <option value="Ms./Mrs.">Ms./Mrs.</option>
                    </select>
                    </div>  

                    <div class="form-field col-md-4 col-sm-12">
                    <label for="first-name<?= $i ?>">First Name</label>
                    <input class="form-control" type="text" id="first-name<?= $i ?>" name="guests[<?= $i ?>][first_name]" required>
                    </div>

                    <div class="form-field col-md-4 col-sm-12">
                    <label for="last-name<?= $i ?>">Last Name</label>
                    <input class="form-control" type="text" id="last-name<?= $i ?>" name="guests[<?= $i ?>][last_name]" required>
                    </div>
                </div>
                </div>

                <div class="div3">
                <h4>Date of Birth</h4>
                    <div class="row dob-section">
                        <div class="form-field col-md-4 col-sm-12" >
                        <label for="yearInput<?= $i ?>">Year</label>
                        <select class="form-control" id="yearInput<?= $i ?>" name="guests[<?= $i ?>][year]" class="dob-select" required>
                            <option value="" disabled selected>Year</option>
                            <?php for ($y = date('Y'); $y >= 1900; $y--): ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                        </div>

                        <div class="form-field col-md-4 col-sm-12">
                        <label for="monthInput<?= $i ?>">Month</label>
                        <select class="form-control" id="monthInput<?= $i ?>" name="guests[<?= $i ?>][month]" class="dob-select" required>
                            <option value="" disabled selected>Month</option>
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>"><?= date("F", mktime(0, 0, 0, $m, 1)) ?></option>
                            <?php endfor; ?>
                        </select>
                        </div>

                        <div class="form-field col-md-4 col-sm-12">
                        <label for="dayInput<?= $i ?>">Day</label>
                        <select class="form-control" id="dayInput<?= $i ?>" name="guests[<?= $i ?>][day]" class="dob-select" required>
                            <option value="" disabled selected>Day</option>
                            <?php for ($d = 1; $d <= 31; $d++): ?>
                                <option value="<?= $d ?>"><?= $d ?></option>
                            <?php endfor; ?>
                        </select>
                        </div>
                    </div>
                    </div>

                    <div class="div4">
                    <div class="form-field">
                        <label for="contact-number<?= $i ?>">Contact Number</label>
                        <input class="form-control" type="number" id="contact-number<?= $i ?>" name="guests[<?= $i ?>][contact]" pattern="[0-9]{10}" required>
                    </div>
                    </div>

                    <div class="div5">
                    <div class="form-field">
                        <label for="nationalityInput<?= $i ?>">Nationality</label>

                        <select class="form-control" type="text" id="nationalityInput<?= $i ?>" name="guests[<?= $i ?>][nationality]" required>
                            <option value="" disabled selected>-- Select Nationality --</option>
                        </select>

                        <script>
                            
                            fetch('nationalities.json')
                                .then(response => response.json())  
                                .then(nationalities => {
                                    const select = document.getElementById("nationalityInput<?= $i ?>");

                                    nationalities.forEach(nationality => {
                                        const option = document.createElement("option");
                                        option.value = nationality;  
                                        option.textContent = nationality;  
                                        select.appendChild(option);  
                                    });
                                })
                                .catch(error => console.error('Error loading the nationalities:', error));
                        </script>
                    </div>
                    </div>

                    <div class="div6">
                    <div class="form-field">
                        <label for="email<?= $i ?>">Email Address</label>
                        <input class="form-control" type="email" id="email<?= $i ?>" name="guests[<?= $i ?>][email]" required>
                    </div>
                    </div>  

                    <div class="div7">
                    <div class="form-field">
                        <label for="retypedemailInput<?= $i ?>">Retype Email Address</label>
                        <input class="form-control" type="email" id="retypedemailInput<?= $i ?>" name="guests[<?= $i ?>][retyped_email]">
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
  
        <div class="container d-flex justify-content-end gap-3" style="padding-top: 20px; padding-bottom: 20px; max-width: 75%;">
              <a class="btn btn-secondary btn-md" href="selectflights.php" role="button" style="margin: 0; ">BACK</a>
              <button type="submit" class="btn btn-primary btn-md" style="margin: 0;margin-right: 20px">CONTINUE</button>
        </div>
        
    </form>


    <script>
        // Pass the PHP session values to JavaScript for debugging purposes
        var selectedDepFlight = "<?php echo isset($_SESSION['selected_depflight']) ? $_SESSION['selected_depflight'] : 'No departing flight selected'; ?>";
        var selectedRetFlight = "<?php echo isset($_SESSION['selected_retflight']) ? $_SESSION['selected_retflight'] : 'No returning flight selected'; ?>";
        var numPassenger = "<?php echo isset($_SESSION['numberofpassenger']) ? $_SESSION['numberofpassenger'] : 'Invalid number of passenger'; ?>";            

        var departingPrice = "<?php echo isset ($_SESSION['departing_price']) ?
              $_SESSION['departing_price'] : 'No departing price submitted'; ?>";
        var returningPrice = "<?php echo isset ($_SESSION['returning_price']) ?
             $_SESSION['returning_price'] : 'No return price submitted'; ?>";
        // Display the values in a pop-up alert for debugging
        alert("Selected Departing Flight: " + selectedDepFlight + "\nSelected Returning Flight: " + selectedRetFlight + "\nNumber of Passenger: " + numPassenger +
            "\nDeparting Price: " + departingPrice + "\nReturning Price: " + returningPrice
        ) ;
    </script>

    <script>
    function isLeapYear(year) {
        return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
    }

    function updateDays(year, month, daySelect) {
        const daysInMonth = [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30,
                            31, 31, 30, 31, 30, 31];
        const maxDay = daysInMonth[month - 1] || 31;

        daySelect.innerHTML = '<option value="" disabled selected>Day</option>';
        for (let d = 1; d <= maxDay; d++) {
        const opt = document.createElement('option');
        opt.value = d;
        opt.text = d;
        daySelect.appendChild(opt);
        }
    }

    // Apply to each passenger
    <?php for ($i = 1; $i <= $numberofPassenger; $i++): ?>
        const year<?= $i ?> = document.getElementById("yearInput<?= $i ?>");
        const month<?= $i ?> = document.getElementById("monthInput<?= $i ?>");
        const day<?= $i ?> = document.getElementById("dayInput<?= $i ?>");

        function handleChange<?= $i ?>() {
        const y = parseInt(year<?= $i ?>.value);
        const m = parseInt(month<?= $i ?>.value);
        if (!isNaN(y) && !isNaN(m)) {
            updateDays(y, m, day<?= $i ?>);
        }
        }

        year<?= $i ?>.addEventListener("change", handleChange<?= $i ?>);
        month<?= $i ?>.addEventListener("change", handleChange<?= $i ?>);
    <?php endfor; ?>
    </script>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="booking.js"></script>

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