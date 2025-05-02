<?php

session_start();
require_once '../database/admin-crud.php';

$adminCrud = new Crud();
$airports = $adminCrud->getAllAirports();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $_SESSION['bookingpage_completed'] = true;

  $_SESSION['selected_from'] = $_POST['from'];
  $_SESSION['selected_to'] = $_POST['to'];
  $_SESSION['num_of_adult'] = $_POST['adult'];
  $_SESSION['num_of_children'] = $_POST['children'];
  $_SESSION['departing_date'] = $_POST['departingDate'];
  $_SESSION['returning_date'] = $_POST['returnDate'];


  if (!empty($_POST['returnDate'])) {
    $_SESSION['trip_type'] = 'roundtrip';
  } else {
      $_SESSION['trip_type'] = 'onewaytrip';
  }

  

  header('Location: selectflights.php');
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

  <!-- Bootstap S icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <title>JetSetGo</title>

  <!-- <link rel="stylesheet" href="bookingpage.css"> -->

  <style>
    .background-image {
      background-image: url('assets/Airport.jpg');
      background-size: cover;
      background-position: center center;
      height: 325px;
      max-width: 100%;
      
    }

    .booking-form {
      display: flex;
      flex-direction: column;
      justify-content: center;   
      align-items: center;       
      height: 0vh;            
      margin-top: 0px;  
      width: 100%;          
      max-width: 1000px;        
      margin: 0 auto;           
    }


    .form-card {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      display: flex;
      column-gap: 90px;
      row-gap: 0px;
      flex-wrap: wrap;
      max-width: 1100px;
      overflow: hidden;
      height: auto;
    }

    .form-section {
      flex: 1;
      min-width: 400px;
      justify-content: center;
    }


    .form-section h2 {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .form-sectiontrip {
      flex: 1;
      min-width: 380px;
    }

    .form-section h2 {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .icon {
      font-size: 20px;
    }

    .form-group {
      display: flex;
      gap: 10px;
      margin-bottom: 15px;
      flex-wrap: wrap;
      
    }
    .form-group.dates {
      display: flex;
      gap: 45px; /* spacing between Departing and Return */
      flex-wrap: wrap; 
    }

    .child-wrapper {
      margin-left: 25px;
      margin-right: 10px;
    }

    .infant-wrapper {
      margin-left: 30px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }


    .trip-options {
      margin-bottom: 15px;
    }

    .trip-options label {
      margin-right: 20px;
      font-weight: normal;
    }

    .search-btn {
      background-color: #0c2d56;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 15px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 20px;
      margin-left: 350px;
    }

    .search-btn:hover {
      background-color: #144785;
    }
    .icon img {
      width: 30px; 
      height: 30px;
      vertical-align: middle; 
      margin-right: 5px; 
    }

    @media (min-width: 1100px) {
      .form-section.flight-section {
        padding-left: 50px; /* left side space of the flight section */
      }
      .form-submit {
        padding-left: 40px; /* srch button space */
        padding-bottom: 35px;
      }
      .form-card {
        padding-top: 55px; /* space on the top side of the form */
      }
    }

    @media (max-width: 1100px) {
    .form-card {
      flex-direction: column;
      align-items: center;
      width: 90%;
    }

    .flight-section {
      order: 1;
    }

    .trip-section {
      order: 2;
    }

    .form-submit {
      order: 3;
      /* margin-top: 1rem; */
      display: flex;
      justify-content: center;
    }
    .booking-form {
      margin-top: 100px;
      justify-content: center;
    }
    .search-btn {
      margin: 0 auto;
      width: 100%;
      max-width: 300px;
    }
    }

    @media (max-width: 992px) {
      .container-fluid {
        flex-direction: row;
        justify-content: space-between;
        padding: 0 1rem;
      }

      .navbar-brand {
        margin-left: 10px;
      }

      .btn {
        margin-right: 10px;
      }
    }

    @media (max-width: 535px) {
    .booking-form {
      max-width: 85%;
      transform: scale(0.8); /* Shrink the whole form */
      padding: 0.5rem;
      margin: 0 auto;
      box-sizing: border-box;
    }

    .form-card {
      padding-top: 10px; /* space on the top side of the form */
    }

    .form-section.flight-section {
      padding-top: 20px;
    }

    .booking-form input,
    .booking-form select,
    .booking-form button {
      font-size: 0.7rem; /* Smaller font */
      padding: 4px 6px; /* Less padding */
      width: 100%;
      box-sizing: border-box;
    }

    .form-section h5 {
      font-size: 0.9rem;
      margin-bottom: 0.3rem;
    }

    .form-submit {
      margin-top: 0.8rem;
      text-align: center;
    }

    .booking-form i {
      font-size: 0.75rem;
    }

    .booking-form label {
      font-size: 0.7rem;
    }

    .booking-form .form-group {
      margin-bottom: 0.5rem;
    }

    .trip-options {
      display: flex;
      flex-wrap: nowrap;
      gap: 10px;
    }

    .trip-options label {
      display: inline-flex;
      align-items: center;
      white-space: nowrap;
    }

    input[type="radio"] {
      transform: scale(1.2); /* radio button size */
      margin-right: 8px; /* gap between the button and label */
    }
  }

  @media (max-width: 440px) {
    .booking-form {
      max-width: 90%;
      transform: scale(0.65); /* Smaller overall scale */
      padding: 0.4rem;
      margin: 0 auto;
      box-sizing: border-box;
    }

    .booking-form input,
    .booking-form select,
    .booking-form button {
      font-size: 0.6rem; /* Even smaller text */
      padding: 2px 4px; /* Less padding for better fit */
      width: 100%;
    }

    .form-section h5 {
      font-size: 0.75rem;
      margin-bottom: 0.15rem;
    }

    .booking-form label {
      font-size: 0.65rem;
    }

    .form-submit {
      margin-top: 0.5rem;
      text-align: center;
    }

    .booking-form i {
      font-size: 0.7rem;
    }

    /* shrink logo + navbar items if needed */
    .navbar-brand {
      font-size: 0.85rem;
      margin-left: 10px;
    }

    .navbar-brand img {
      width: 35px;
      height: 35px;
    }

    .btn {
      font-size: 0.7rem;
      margin: 0 10px;
      padding: 4px 8px;
    }
  }


  </style>

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


  <main>
    <section class="background-image">

    </section>

    <section class="booking-form">
      <form method="POST" action="">

        <div class="form-card">
          <div class="form-section flight-section">
            <h2><span class="icon"><img src="assets/logo.png" alt="" /></span> Flight</h2>

            
            <div class="form-group">
              <label for="fromInput" style="display:flex; justify-content: center; align-items: center">From</label>
              <select id="fromInput" name="from" style="width: 150px;" required>
              <option value="" selected hidden>Select Location</option>
                <?php foreach ($airports as $airport): ?>
                  <option value="<?= htmlspecialchars($airport['airport_code']) ?>">
                    <?= htmlspecialchars($airport['airport_location']) ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <label for="toInput" style="display:flex; justify-content: center; align-items: center">To</label>
              <select id="toInput" name="to" style="width: 150px;" required>
              <option value="" selected hidden>Select Location</option>
                <?php foreach ($airports as $airport): ?>
                  <option value="<?= htmlspecialchars($airport['airport_code']) ?>">
                    <?= htmlspecialchars($airport['airport_location']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>


            <div class="form-group" style="display: flex;">
              <div style="display: flex; flex-direction: column;">
                <label for="adultInput">Adult</label>
                <input type="number" min="1" max="4" placeholder="1" id="adultInput" name="adult" style="width: 175px;" required/>
              </div>

              <div class="child-wrapper" style="display: flex; flex-direction: column; margin-left: 20px;">
                <label for="childrenInput">Children</label>
                <input type="number" max="2" id="childrenInput" name="children" style="width: 175px;" placeholder="0"/>
              </div>

            </div>
          </div>

          <div class="form-section trip-section">
            <h2><span class="icon"><img src="assets/logo.png" alt="" /></span> Trip</h2>
            <div class="trip-options">
              <label><input type="radio" name="trip" id="roundTrip" checked /> Round Trip</label>
              <label><input type="radio" name="trip" id="oneWayTrip" /> One-way Trip</label>
            </div>

            <div class="form-group dates">
              <div style="display: flex; flex-direction: column;">
                <label for="departingDate">Departing</label>
                <input type="date" id="departingDate" name="departingDate" placeholder="Departing" style="width: 150px;" />
              </div>

              <div style="display: flex; flex-direction: column;">
                <label for="returnDate" id="returnLabel">Return</label>
                <input type="date" id="returnDate" name="returnDate" placeholder="Return" style="width: 150px;" /> 
              </div>
            </div>

            <script>
              const roundTrip = document.getElementById('roundTrip');
              const oneWayTrip = document.getElementById('oneWayTrip');
              const returnDate = document.getElementById('returnDate');
              const returnLabel = document.getElementById('returnLabel');
              const departingDate = document.getElementById('departingDate'); // <-- you missed this

              function toggleReturnDate() {
                if (oneWayTrip && oneWayTrip.checked) {
                  returnDate.style.display = 'none';
                  returnLabel.style.display = 'none';
                  returnDate.required = false;
                  departingDate.required = true;
                } else {
                  returnDate.style.display = 'block';
                  returnLabel.style.display = 'block';
                  returnDate.required = true;
                  departingDate.required = true;
                }
              }

              toggleReturnDate();
              if (roundTrip) roundTrip.addEventListener('change', toggleReturnDate);
              if (oneWayTrip) oneWayTrip.addEventListener('change', toggleReturnDate);
            </script>

          </div>

          <div class="form-submit">
            <button class="search-btn"><i class="bi bi-airplane"></i> Search Flights</button>
          </div>
        </div>

      </form>
    </section>




  </main>


  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- <script src="booking.js"></script> -->

</body>

</html>