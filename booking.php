<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JetSetGo - Flight Booking</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="navbar">
    <div class="navbar-left">
      <img src="assets/JetSetGo_Logo-removebg.png" alt="" class="logo" />
      <h1 class="brand-name">JetSetGo</h1>
    </div>
    
    <div class="navbar-right">
      
      <button class="cancel-btn">Cancel Booking</button>
    </div>
  </header>

  <main>
    
    <section class="background-image">
      
    </section>

    <section class="booking-form">
  <div class="form-card">
    <div class="form-section">
      <h2><span class="icon"><img src="assets/Logo.png" alt="" /></span> Flight</h2>
      <div class="form-group">

      <label for="fromInput">From</label>
      <input type="text" id="fromInput" name="from" style="width: 150px;"/>

      <label for="ToInput">To</label>
      <input type="text" id="toInput" name="To" style="width: 150px;"/>  

      </div>

      <div class="form-group" style="display: flex;">
  <div style="display: flex; flex-direction: column;">
    <label for="adultInput">Adult</label>
    <input type="number" id="adultInput" name="adult" style="width: 100px;" />
  </div>

  <div class="child-wrapper" style="display: flex; flex-direction: column; margin-left: 20px;">
    <label for="childrenInput">Children</label>
    <input type="number" id="childrenInput" name="children" style="width: 100px;" />
  </div>

  <div class="infant-wrapper" style="display: flex; flex-direction: column; margin-left: 30px;">
    <label for="infantInput">Infant</label>
    <input type="number" id="infantInput" name="infant" style="width: 80px;" />
  </div>
</div>


<div class="form-submit">
          <button class="search-btn">Search Flights</button>
        </div>

    </div>

    

    <div class="form-section">
  <h2><span class="icon"><img src="assets/Logo.png" alt="" /></span> Trip</h2>
  <div class="trip-options">
    <label><input type="radio" name="trip" id="roundTrip" checked /> Round Trip</label>
    <label><input type="radio" name="trip" id="oneWayTrip" /> One-way Trip</label>
  </div>
  <div class="form-group">
  <div style="display: flex; flex-direction: column;">
    <label for="departingDate">Departing</label>
    <input type="date" id="departingDate" placeholder="Departing" />
  </div>

  <div style="display: flex; flex-direction: column;">
  <label for="returnDate" id="returnLabel">Return</label>
  <input type="date" id="returnDate" placeholder="Return" />
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
  
</section>

  </main>
</body>
</html> 