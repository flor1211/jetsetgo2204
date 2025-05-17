<?php
  session_start();

  require_once '../database/admin-crud.php';

  require_once '../database/booking-crud.php';
 

 
  if (!isset($_SESSION['guestdetails_completed'])) {
    header('Location: guestdetails.php');
    exit();
  }

  $selectedDepFlight = $_SESSION['selected_depflight'] ?? null;
  $selectedRetFlight = $_SESSION['selected_retflight'] ?? null;
  $numberofPassenger = $_SESSION['numberofpassenger'];


  $user = new Crud();
  $bookingUser = new BookingCrud();

  $depFlightInfo = $bookingUser->getSelectedFlight($selectedDepFlight);
  $retFlightInfo = $bookingUser->getSelectedFlight($selectedRetFlight);



  $_SESSION['total_price'] = ($_SESSION['departing_price'] + $_SESSION['returning_price']) * $_SESSION['numberofpassenger'];
  $baseprice = (float) ($_SESSION['departing_price'] + $_SESSION['returning_price']);
  $totalprice = (float) $_SESSION['total_price'];



  $tax = (float)  ($totalprice * 0.10);


  $flightType = $_SESSION['trip_type'];

  $guestDetails = $_SESSION['guest_details'] ?? [];


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['confirmbooking'])){


      
    
      $payment_type = $_POST['payment'];


      if ($flightType == 'roundtrip') {

        $depFlight = $depFlightInfo[0];
        $retFlight = $retFlightInfo[0];
  
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

        if ($payment_type === 'on-site') {

            $id_name = $_POST['onsite_name'];
            $id_number = $_POST['onsite_idnum'];

            $bookingUser->addPaymentOnSite($DEPbookingID, $name, $idnumber,);
            $bookingUser->addPaymentOnSite($RETbookingID, $name, $idnumber,);
            echo "On-site payment recorded. Please pay at the airport.";
        }

        else if ($payment_type === 'card') {
            $card_holder = $_POST['card_holder'];
            $card_number = $_POST['card_number'];
            $card_expiry = $_POST['card_expiry'];
            $bookingUser->addPaymentCard($DEPbookingID, $card_holder, $card_number, $card_expiry, $card_cvv);
            $bookingUser->addPaymentCard($RETbookingID, $card_holder, $card_number, $card_expiry, $card_cvv);
            echo "Card payment successful. Your booking is confirmed.";
        }



      } else if ($flightType == 'onewaytrip') {

        $depFlight = $depFlightInfo[0];

        $DEPbookingID = $bookingUser->newBooking($depFlight['flight_id'], $depFlight['date'], $depFlight['departure_time'], $depFlight['departure_code'], $depFlight['departure_location'], $depFlight['arrival_time'], $depFlight['arrival_code'], $depFlight['arrival_location'], $depFlight['plane_code'], $depFlight['plane_photo'], $depFlight['price']);
        foreach ($guestDetails as $guest) {
            // echo "<h3>Guest Details</h3><pre>";
            // print_r($guest);
            // echo "</pre>";
            $bookingUser->addGuestDetails($DEPbookingID, $guest['title'], $guest['first_name'], $guest['last_name'], $guest['year'].$guest['month'].$guest['day'], $guest['contact'], $guest['nationality'], $guest['email']);
        }

        if ($payment_type === 'on-site') {
          
            $id_name = $_POST['onsite_name'];
            $id_number = $_POST['onsite_idnum'];

            $bookingUser->addPaymentOnSite($DEPbookingID, $id_name, $id_number,);
            echo "On-site payment recorded. Please pay at the airport.";
        }

        else if ($payment_type === 'card') {
            $card_holder = $_POST['card_holder'];
            $card_number = $_POST['card_number'];
            $card_expiry = $_POST['card_expiry'];
            $card_cvv = $_POST['card_cvv'];


            $bookingUser->addPaymentCard($DEPbookingID, $card_holder, $card_number, $card_expiry, $card_cvv);
            echo "Card payment successful. Your booking is confirmed.";
        }

      }
   
      $_SESSION['payments_completed'] = true;
      header('Location: ../mail.php');

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

      <!-- SWEET -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    @media (max-width: 768px) {
      .flightinfo {
        justify-content: center;
      }
      
      h7 {
        display: none;
      }

      row {
        width: 100%;
      }

    }

    @media (max-width: 736px) {
      row {
        width: 100%;
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

        <!-- Navbar -->
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

<br>

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
      <div class="row mb-3">
        <div class="flightinfo col-md-<?= ($flightType === 'onewaytrip') ? '12' : '6' ?>">
          <b><?= $depFlightInfo[0]['departure_code'] ?></b><h7> <?= $depFlightInfo[0]['departure_location'] ?></h7>
          to
          <b><?= $depFlightInfo[0]['arrival_code'] ?></b><h7>  <?= $depFlightInfo[0]['arrival_location'] ?></h7><br>
          <small>
            <?= date("d F Y", strtotime($depFlightInfo[0]['date'])) ?> |
            <?= date("g:i A", strtotime($depFlightInfo[0]['departure_time'])) ?> -
            <?= date("g:i A", strtotime($depFlightInfo[0]['arrival_time'])) ?>
          </small>


        </div>

        <?php if ($flightType === 'roundtrip'): ?>
          <div class=" flightinfo col-md-6">
            <b><?= $retFlightInfo[0]['departure_code'] ?></b><h7>  <?= $retFlightInfo[0]['departure_location'] ?></h7>
            to
            <b><?= $retFlightInfo[0]['arrival_code'] ?></b><h7>  <?= $retFlightInfo[0]['arrival_location'] ?></h7><br>
            <small>
              <?= date("d F Y", strtotime($retFlightInfo[0]['date'])) ?> |
              <?= date("g:i A", strtotime($retFlightInfo[0]['departure_time'])) ?> -
              <?= date("g:i A", strtotime($retFlightInfo[0]['arrival_time'])) ?>
          </small>          </div>
        <?php endif; ?>
      </div>

        <hr>  
        <?php
            for ($i = 1; $i <= $numberofPassenger; $i++):
          ?>
            <div class="d-flex justify-content-between mb-3 ms-5">
            <span>Passenger <?= $i ?></span>
            <span class="me-5"><b>PHP <?= $baseprice?></b></span>
            </div>
        
          <?php endfor; ?>

        <div class="d-flex justify-content-between mb-1 ms-5">
          <span>Taxes and Fees</span>
          <span class="me-5"><b>PHP <?= $tax ?></b></span>
        </div>
      </div>
      <div class="d-flex justify-content-between fw-bold px-4 py-2" style="background-color:rgb(154, 167, 231); color: #000;">
        <span class="ms-5">Total</span>
        <span class="me-5">PHP <?= $totalprice + $tax ?> </span>
      </div>
    </div>

    <!-- FORM START -->
    <form method="POST" action="#">

      <h3 style="font-weight: 700;">Payment Method</h3>
      <h6>Select your preferred payment option</h6>

      <div class="p-4 bg-white shadow rounded">
        <h5 style="text-align: center; margin-top: 10px;">
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
                <input type="text" class="form-control" id="name" name="card_name" placeholder="Enter your name" style="margin-bottom: 15px;" required>
                <label for="cardNumber" class="form-label">Card Number</label>
                <input type="number" class="form-control" id="cardNumber" name="card_number" placeholder="XXXX XXXX XXXX XXXX" style="margin-bottom: 15px;">
                
                <div class="row">
                  <div class="col-md-6">
                    <label for="expiry" class="form-label">VALID THRU</label>
                    <input type="month" class="form-control" id="expiry" name="expiry" placeholder="YYYY/MM" style="height: 58%;">
                  </div>
                  <div class="col-md-6">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="number" class="form-control" id="cvv" name="cvv" maxlength="3">
                  </div>
                </div>
               
              </div>
            </div>
          </div>

          <label class="payment-option d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <input type="radio" name="payment" value="on-site" onclick="toggleCollapse('on-site')" >
            <img src="https://icon-library.com/images/flight-icon/flight-icon-4.jpg" alt="Flight Icon" height="24"> On-Site Payment
            </div>
          </label>

          <div class="collapse mt-2" id="onsiteCollapse" style="margin-bottom: 10px;">
            <div class="card card-body">
              <div class="mb-3">
                <label for="onsite_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="onsite_name" name="onsite_name" placeholder="Enter your name" >
                </div>

                <label for="onside-idnum" class="form-label">Valid ID Number</label>
                <input type="number" class="form-control" id="onsite_idnum" name="onsite_idnum" placeholder="Enter your valid ID number" >
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


      <div class="container d-flex justify-content-center gap-2" style="padding-top: 20px; padding-bottom: 20px; max-width: 75%;">
        <button type="submit" name="confirmbooking" class="btn btn-success btn-md" style="margin: 0; width: 200px;">PAY</button>
        <a class="btn btn-secondary btn-md" href="guestdetails.php" role="button" style="margin: 0;width: 100px;">BACK</a>
      </div>

    </form>

  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function toggleCollapse(option) {
    const creditCard = document.getElementById('creditCardCollapse');
    const onsite = document.getElementById('onsiteCollapse');

    const creditCollapse = bootstrap.Collapse.getOrCreateInstance(creditCard, { toggle: false });
    const onsiteCollapse = bootstrap.Collapse.getOrCreateInstance(onsite, { toggle: false });

    if (option === 'card') {
      creditCollapse.show();
      onsiteCollapse.hide();
    } else if (option === 'on-site') {
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
    } else if (option === 'on-site') {
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