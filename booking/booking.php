<?php

session_start();
require_once '../database/admin-crud.php';

$adminCrud = new Crud();
$airports = $adminCrud->getAllAirports();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $_SESSION['bookingpage_complated'] = true;

  $_SESSION['selected_from'] = $_POST['from'];
  $_SESSION['selected_to'] = $_POST['to'];
  $_SESSION['num_of_adult'] = $_POST['adult'];
  $_SESSION['num_of_children'] = $_POST['children'];
  $_SESSION['departing_date'] = $_POST['departingDate'];
  $_SESSION['return_date'] = $_POST['returnDate'];

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

  <link rel="stylesheet" href="bookingpage.css">

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
            <h2><span class="icon"><img src="../assets/Logo.webp" alt="" /></span> Flight</h2>

            <div class="form-group">
              <label for="fromInput" style="display:flex; justify-content: center; align-items: center">From</label>
              <select id="fromInput" name="from" style="width: 150px;" required>
              <option value="" selected hidden>Select Location</option>
                <?php foreach ($airports as $airport): ?>
                  <option value="<?= htmlspecialchars($airport['airport_code']) ?>">
                    <?= htmlspecialchars($airport['airport_code']) ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <label for="toInput" style="display:flex; justify-content: center; align-items: center">To</label>
              <select id="toInput" name="to" style="width: 150px;" required>
              <option value="" selected hidden>Select Location</option>
                <?php foreach ($airports as $airport): ?>
                  <option value="<?= htmlspecialchars($airport['airport_code']) ?>">
                    <?= htmlspecialchars($airport['airport_code']) ?>
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
            <h2><span class="icon"><img src="../assets/Logo.png" alt="" /></span> Trip</h2>
            <div class="trip-options">
              <label><input type="radio" name="trip" id="roundTrip" checked /> Round Trip</label>
              <label><input type="radio" name="trip" id="oneWayTrip" /> One-way Trip</label>
            </div>

            <div class="form-group dates">
              <div style="display: flex; flex-direction: column;">
                <label for="departingDate">Departing</label>
                <input type="date" id="departingDate" name="departingDate"placeholder="Departing" style="width: 150px;" />
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

              function toggleReturnDate() {
                if (oneWayTrip.checked) {
                  returnDate.style.display = 'none';
                  returnLabel.style.display = 'none';
                } else {
                  returnDate.style.display = 'block';
                  returnLabel.style.display = 'block';
                }
              }

              toggleReturnDate();
              roundTrip.addEventListener('change', toggleReturnDate);
              oneWayTrip.addEventListener('change', toggleReturnDate);
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

  <script src="booking.js"></script>

</body>

</html>