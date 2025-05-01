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
      
      echo "<script>alert('Form submitted successfully!');</script>"; 
      echo "<h3>Payment Details</h3><pre>";
      print_r($_POST);
      echo "</pre>";

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
  <title>JetSetGo</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="booking-style.css">

  <style>
    /* .mop-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
    } */
    .payment-option {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }
    .payment-option input {
      margin-right: 12px;
    }
    .payment-option img {
      height: 20px;
      margin-left: auto;
      margin-right: 6px;
    }
    .checkbox {
      margin-top: 10px;
      margin-left: 5px;
    }
    .order-btn {
      margin-top: 20px;
      width: 100%;
      background-color: #0070f3;
      color: white;
      border: none;
      padding: 14px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
    }
    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: #888;
    }
    .footer img {
      height: 16px;
      vertical-align: middle;
    }
  </style>
</head>
<body style="margin: 0;">

<!-- Navbar -->
<div id="navbar-container">
  <script>
    fetch("topbar.php")
      .then(res => res.text())
      .then(data => {
        document.getElementById("navbar-container").innerHTML = data;
      });
  </script>
</div>

<!-- Steps -->
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

<!-- Main Content -->
<div class="container my-4 d-flex justify-content-center">
  <div class="w-100" style="max-width: 800px;">
    <h3 style="font-weight: 700;">Booking Summary</h3>
    <h6>Review your booking before proceeding to payment</h6>

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

    <!-- FORM START -->
    <form method="POST" action="">

      <h3 style="font-weight: 700;">Payment Method</h3>
      <h6>Select your preferred payment option</h6>

      <div class="p-4 bg-white shadow rounded">
        <h5 style="text-align: center; margin-top: 10px;">
          <!-- <i class="bi bi-credit-card me-2"></i><b>PAYMENT</b> -->
        </h5>
  
          <label class="payment-option">
            <input type="radio" name="payment" value="card" onclick="toggleCollapse('card')">
            <i class="bi bi-credit-card me-2"></i> Credit card / Debit card
              <img src="https://logos-world.net/wp-content/uploads/2020/04/Visa-Logo-2014-present.jpg" alt="Visa" height="24">
              <img src="https://www.adweek.com/wp-content/uploads/2019/01/mastercard-new-logo-content-2019.jpg" alt="MasterCard" height="24">
              <img src="https://thafd.bing.com/th/id/OIP.R0QL0o4N9PXcUNuqoQ2wKAAAAA?rs=1&pid=ImgDetMain" alt="AmEx" height="24">
          </label>

          <!-- COLLAPSE ITO -->
          <div class="collapse mt-2" id="creditCardCollapse" style="margin-bottom: 10px;">
            <div class="card card-body">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="Name" placeholder="Enter your name" style="margin-bottom: 15px;" required>
                <label for="cardNumber" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="cardNumber" name="card-number" placeholder="XXXX XXXX XXXX XXXX" style="margin-bottom: 15px;">
                
                <div class="row">
                  <div class="col-md-6">
                    <label for="month" class="form-label">VALID THRU</label>
                    <input type="month" class="form-control" id="month" name="month" placeholder="YYYY/MM" style="height: 58%;">
                  </div>
                  <div class="col-md-6">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3">
                  </div>
                </div>

              


                
              </div>
            </div>
          </div>

          <label class="payment-option d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <input type="radio" name="payment" value="bank" onclick="toggleCollapse('bank')" >
            <img src="https://icon-library.com/images/flight-icon/flight-icon-4.jpg" alt="Flight Icon" height="24"> On-Site Payment
            </div>
          </label>

          <div class="collapse mt-2" id="onsiteCollapse" style="margin-bottom: 10px;">
            <div class="card card-body">
              <div class="mb-3">
                <label for="onsite-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="onsite-name" name="onsite-name" placeholder="Enter your name" >
                </div>

                <label for="valid-id" class="form-label">Valid ID Number</label>
                <input type="text" class="form-control" id="valid-id" name="valid-id" placeholder="Enter your valid ID number" >
              </div>
              

        </div>
      </div>
 

      <!-- Terms & Conditions -->
      <div class="white shadow border rounded p-2 bg-white my-3">
        <div class="d-flex align-items-start p-2">
          <input type="checkbox" id="IAgree" required class="mt-1 me-2">
          <label for="IAgree">
            By clicking the checkbox, I confirm that I have read, understand, and accept the Booking Conditions & Airline Policy.
          </label>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="d-flex justify-content-end align-items-end w-100" style="height: 100px;">
        <a href="addons.php" class="btn btn-secondary me-3" style="width: 150px; height: 40px;">Back</a>
        <button type="submit" class="btn btn-primary" style="width: 150px; height: 40px;">Confirm</button>
      </div>

    </form>
    <!-- FORM END -->

  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="booking.js"></script>

<script>
  function toggleCollapse(option) {
    const creditCard = document.getElementById('creditCardCollapse');
    const onsite = document.getElementById('onsiteCollapse');

    const creditCollapse = bootstrap.Collapse.getOrCreateInstance(creditCard, { toggle: false });
    const onsiteCollapse = bootstrap.Collapse.getOrCreateInstance(onsite, { toggle: false });

    if (option === 'card') {
      creditCollapse.show();
      onsiteCollapse.hide();
    } else if (option === 'bank') {
      creditCollapse.hide();
      onsiteCollapse.show();
    }
  }

  function toggleCollapse(option) {
  const creditCard = document.getElementById('creditCardCollapse');
  const onsite = document.getElementById('onsiteCollapse');

  const creditCollapse = bootstrap.Collapse.getOrCreateInstance(creditCard, { toggle: false });
  const onsiteCollapse = bootstrap.Collapse.getOrCreateInstance(onsite, { toggle: false });

  // Hide both and remove 'required'
  creditCollapse.hide();
  onsiteCollapse.hide();
  toggleRequiredFields(creditCard, false);
  toggleRequiredFields(onsite, false);

  if (option === 'card') {
    creditCollapse.show();
    toggleRequiredFields(creditCard, true);
  } else if (option === 'bank') {
    onsiteCollapse.show();
    toggleRequiredFields(onsite, true);
  }
}

function toggleRequiredFields(container, isRequired) {
  const inputs = container.querySelectorAll('input');
  inputs.forEach(input => {
    if (isRequired) {
      input.setAttribute('required', 'required');
    } else {
      input.removeAttribute('required');
    }
  });
}

</script>




</body>
</html>
