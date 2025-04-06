<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JetSetGo - Flight Booking</title>
  <link rel="stylesheet" href="CStmrBooking.css" />
</head>
<body>
  <header class="navbar">
    <div class="navbar-left">
      <img src="JetSetGo_Logo-removebg.png" alt="" class="logo" />
      <h1 class="brand-name">JetSetGo</h1>
    </div>
    <div class="navbar-right">
      <span class="current-time">10:00pm | Saturday, January 1, 2025</span>
      <button class="cancel-btn">Cancel Booking</button>
    </div>
  </header>

  <main>
    
    <section class="background-image">
      
    </section>

    <section class="booking-form">
  <div class="form-card">
    <div class="form-section">
      <h2><span class="icon"><img src="Logo.png" alt="Plus Icon" /></span> Flight</h2>
      <div class="form-group">
        <input type="text" placeholder="From" />
        <input type="text" placeholder="To" />
      </div>
      <div class="form-group">
        <input type="number" placeholder="Adult" />
        <input type="number" placeholder="Children" />
        <input type="number" placeholder="Infant" />
      </div>
    </div>

    <div class="form-submit">
          <button class="search-btn">Search Flights</button>
        </div>

        <div class="form-section">
  <h2><span class="icon"><img src="Logo.png" alt="Plus Icon" /></span> Trip</h2>
  <div class="trip-options">
    <label><input type="radio" name="trip" id="roundTrip" checked /> Round Trip</label>
    <label><input type="radio" name="trip" id="oneWayTrip" /> One-way Trip</label>
  </div>
  <div class="form-group">
    <input type="date" id="departingDate" placeholder="Departing" />
    <input type="date" id="returnDate" placeholder="Return" />
  </div>
</div>

<script>
  const roundTrip = document.getElementById('roundTrip');
  const oneWayTrip = document.getElementById('oneWayTrip');
  const returnDate = document.getElementById('returnDate');

  function toggleReturnDate() {
    returnDate.disabled = oneWayTrip.checked;
  }

// minor changes

  toggleReturnDate();

  
  roundTrip.addEventListener('change', toggleReturnDate);
  oneWayTrip.addEventListener('change', toggleReturnDate);
</script>

    
  </div>
  
</section>

  </main>
</body>
</html> 