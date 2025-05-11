<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_SESSION['bookingpage_completed'] = true;
      $_SESSION['selected_from'] = $_POST['from_airport'];
      $_SESSION['selected_to'] = $_POST['to_airport'];
      $_SESSION['trip_type'] = $_POST['trip_type'];
      $_SESSION['departing_date'] = $_POST['depart_date'];
      $_SESSION['returning_date'] = $_POST['return_date'];
      $_SESSION['num_of_adult'] = 1; // Default value
      $_SESSION['num_of_children'] = 0; // Default value
      header('Location: booking/selectflights.php');
      exit();
  }

  // Retrieve the values from session (for use in your page)
  $from = isset($_SESSION['from_airport']) ? $_SESSION['from_airport'] : '';
  $to = isset($_SESSION['to_airport']) ? $_SESSION['to_airport'] : '';
  $trip = isset($_SESSION['trip_type']) ? $_SESSION['trip_type'] : '';
  $depart = isset($_SESSION['depart_date']) ? $_SESSION['depart_date'] : '';
  $return = isset($_SESSION['return_date']) ? $_SESSION['return_date'] : '';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JetSetGo</title>
    <meta name="description" content="JetSetGo - Streamlining your flight booking experience with simplicity and speed." />
    <meta name="keywords" content="flight, booking, travel, JetSetGo, airline, Philippines" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Preload Hero Image -->
    <link rel="preload" href="assets/bg.webp" as="image" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="style.css" />

    <!-- Remix Icon CDN for navbar icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
      :root {
        --header-height: 4.5rem;
        --z-fixed: 1000;
        --second-font: 'Segoe UI', Arial, sans-serif;
        --font-semi-bold: 600;
        --font-medium: 500;
        --body-font: "Poppins", sans-serif;
        --biggest-font-size: 4.5rem;
        --h1-font-size: 1.5rem;
        --h2-font-size: 1.25rem;
        --h3-font-size: 1rem;
        --normal-font-size: .938rem;
        --small-font-size: .813rem;
        --smaller-font-size: .75rem;
        --font-regular: 400;
        --z-tooltip: 10;
      }

      body {
        margin: 0;
        font-family: var(--body-font);
        background-color: #f8f9fa;
        overflow: auto;
      
      }

      html {
        scroll-behavior: smooth;
      }

    /*=============== HEADER & NAV ===============*/
.header{
  position: fixed;
  width: 100%;
  background-color: transparent;
  top: 0;
  left: 0;
  z-index: var(--z-fixed);
  box-shadow: none;
}

nav{
  height: var(--header-height);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
  height: var(--header-height);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav__logo {
  display: flex;
  align-items: center;
  color: rgb(0, 0, 0);
  font-family: var(--second-font);
  font-weight: var(--font-semi-bold);
  font-size: var(--h1-font-size);
  text-decoration: none;
}

.nav__logo img {
  display: none;
}

.nav__toggle,
.nav__close{
  display: flex;
  font-size: 1.25rem;
  color: rgb(0, 0, 0); 
  cursor: pointer;
}

/* Navigation for mobile devices */
@media screen and (max-width: 1023px){
  .nav__menu{
    position: fixed;
    top: -100%;
    left: 0;
    background-color: hsla(0, 0%, 100%, 0.3);
    width: 100%;
    padding-block: 4rem;
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    transition: top .4s;
    min-height: 40vh;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    overflow: visible;
  }
  .nav__close{
    position: absolute;
    top: 1rem;
    right: 1.5rem;
    z-index: 10;
  }
  .nav__list{
    display: flex;
    flex-direction: column !important;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    gap: 2.5rem;
    margin: 0;
    padding: 0;
  }
  .nav__item {
    width: 100%;
    text-align: center;
  }
}
  
.nav__list{
  list-style: none;
  display: flex;
  flex-direction: row;
  column-gap: 4rem;
  align-items: center;
  justify-content: center;
  padding: 0;
  margin: 0;
}

.nav__item {
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav__link {
  position: relative;
  color: rgb(0, 0, 0);
  font-family: var(--second-font);
  font-weight: var(--font-medium);
  font-size: var(--normal-font-size);
  text-decoration: none !important;
}

.nav__link::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -4px;
  width: 0;
  height: 2px;
  background: rgb(0, 0, 0);
  transition: width 0.3s cubic-bezier(.4,0,.2,1);
}

.nav__link:hover::after,
.nav__link.active-link::after {
  width: 70%;
}

.nav__close{
  position: absolute;
  top: 1rem;
  right: 1.5rem;
}

/* Show menu */
.show-menu{
  top: 0;
}

/* Add blur to header */
.blur-header::after{
  content: '';
  position: absolute;
  width: 1000%;
  height: 100%;
  background-color: hsla(0, 0%, 100%, .3);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  top: 0;
  left: 0;
  z-index: -1;
}

      .hero-section {
        background-image: url('assets/img/home-background.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        width: 100vw;
        display: flex;
        flex-direction: column;
        position: relative;
        color: white;
        margin-bottom: -5px;
        padding-top: 30px;
      }
      .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
        pointer-events: none;
      }
      nav.navbar {
       width: 100%;
       list-style: none;
       display: flex;
       justify-content: flex-end;
       align-items: center;
      }
      
      nav.li{
        height: 100%;
        padding: 0 30px;
        text-decoration: none;
        display: flex;
        align-items: center;
        color: white;
        transition: scale 0.2 ease;
      }

      nav a:hover{
       scale: 1.05;
       color: #fff;
      }   

      nav li:first-child{
        margin-right: auto; 
      }

      .sidebar {
        position: absolute;
        top: 60px;
        right: 2rem;
        width: 250px;
        z-index: 999;
        background-color: rgba(240, 240, 240, 0.02);
        backdrop-filter: blur(15px);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;

  
        opacity: 0;
        transform: translateX(100%);
        pointer-events: none;
        transition: transform 0.3s ease, opacity 0.3s ease;
      }

      .sidebar.active {
        opacity: 1;
        transform: translateX(0);
        pointer-events: auto;
      }

      .sidebar li{
        padding: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        list-style: none;
        
      }

      .sidebar a{
        width: 100%;
      }

      .menu-button{
        display: none;
      }

      @media(max-width: 800px){
        .hideOnMobile{
          display: none;
        }
        .menu-button{
          display: block;
        }
      }
      

      @media(max-witdh: 400px){
        .sidebar{
          width: unset;
          left: 2rem;

       }
      }
      
      .home__title{
  font-size: var(--biggest-font-size);
  text-align: center;
  margin-bottom: .1rem;
  font-weight: var(--font-semi-bold);
}
.home__subtitle{
  font-size: var(--h2-font-size);
  margin-bottom: .1rem;
  font-weight: var(--font-semi-bold);
}


      .hero-content {
       position: relative;
       z-index: 2;
       display: flex;
       flex-direction: column;
       align-items: center;
       justify-content: center;
       min-height: 100vh;
      }
      .btn-darkblue {
        background-color: #1e2a50;
        color: #fff;
        padding: 0.5rem 1rem;
        border: none;
        outline: none;
        border-radius: 20px;
        cursor: pointer;
        transition: scale 0.2 ease;
      }
      .btn-darkblue:hover {
        scale: 1.075;
        color: #fff;
      }
      .carousel {
        margin-top: -5px;
      }
      .carousel-inner {
        max-height: 750px;
      }
      .carousel-inner img {
        height: 100%;
        max-height: 750px;
        object-fit: cover;
        width: 100%;
      }
      @media (max-width: 768px) {
        .carousel-inner,
        .carousel-inner img {
          height: 300px;
        }
        .hero-content h1,
        .contact-header h1,
        .about-header h1 {
          font-size: 2rem;
        }
      }
      .about-header {
        background: url('assets/bg2.webp') no-repeat center center;
        background-size: cover;
        background-color: #0c1a3c;
        padding: 70px 0 40px;
        color: white;
        text-align: left;
      }
      .about-header h1 {
        font-weight: bold;
      }
      .about-section {
        background: white;
        padding: 40px 30px;
      }
      .contact-section {
        background-color: white;
        padding: 50px 30px;
        border-radius: 8px;
        margin-top: -50px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }
      .social-icons a {
        color: #000;
        margin: 0 8px;
        font-size: 1.5rem;
      }
      .footer {
        background-color: #0c1a3c;
        color: white;
        text-align: center;
        padding: 20px;
      }
      .footer img {
        height: 30px;
        width: 30px;
        margin-right: 10px;
      }

      /* Force header and nav backgrounds to be transparent for blur effect */
      .header,
      header,
      nav,
      .nav.container {
        background: transparent !important;
        box-shadow: none !important;
      }

      header#header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1100;
      }

      @media screen and (min-width: 1023px) {
        .nav__close, 
        .nav__toggle {
          display: none;
        }
      }

  .nav__list {
    flex-direction: row;
    column-gap: 4rem;
  }
  
    </style>
  </head>

  <body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
    <nav class="nav container">
        <a href="#" class="nav__logo">
          JetSetGo
        </a>
        <div class="nav__menu" id="nav-menu">
           <ul class="nav__list">
            <li class="nav__item">
                <a href="#home" class="nav__link active-link">Home</a>
            </li>
            <li class="nav__item">
                <a href="#gallery-section" class="nav__link">Gallery</a>
            </li>
            <li class="nav__item">
                <a href="#about" class="nav__link">About</a>
            </li>
          
            <li class="nav__item">
                <a href="login.php" class="nav__link">Login</a>
            </li>
           </ul>

           <!--Close button -->
           <div class="nav__close" id="nav-close">
           <i class="ri-close-line"></i>
           </div>
        </div>  

           <!-- Toggle button -->

           <div class="nav__toggle" id="nav-toggle">
           <i class="ri-menu-fill"></i>
           </div>
    </nav>
   </header>
    <!-- Hero Section -->
    <section class="hero-section" id="home">
      <div class="hero-overlay"></div>
      <div class="hero-content text-white">
      <h3 class="home__subtitle">
                Welcome to JetSetGo
            </h3>
      <h1 class="home__title">
                Explore <br>
                The Philippines
            </h1>
      <!-- Flight Search Box Start -->
      <form action="booking/selectflights.php" method="POST" class="flight-search-box rounded-3 shadow p-3 mb-4 d-flex flex-column gap-3" style="max-width: 1400px; margin: 16px auto 0 auto; position: relative; z-index: 3; background: rgba(255,255,255,0.55); backdrop-filter: blur(8px); border-radius: 16px; padding-top: 24px;">
        <div class="d-flex flex-row w-100 gap-3 align-items-end">
          <!-- From field -->
          <div class="flex-grow-1 d-flex flex-column align-items-start" style="min-width: 260px;">
            <label class="form-label mb-1 fw-bold text-dark" style="font-size: 1.15rem;">From</label>
            <select name="from_airport" class="form-select form-select-lg h-100" id="from-airport" style="font-size: 1.15rem;">
              <option value="" selected>Select Location</option>
              <option value="MNL">Metro Manila</option>
              <option value="CRK">New Clark City, Tarlac</option>
              <option value="CEB">Mactan, Cebu</option>
              <option value="BTG">Batangas City</option>
            </select>
          </div>
          <!-- To field -->
          <div class="flex-grow-1 d-flex flex-column align-items-start" style="min-width: 260px;">
            <label class="form-label mb-1 fw-bold text-dark" style="font-size: 1.15rem;">To</label>
            <select name="to_airport" class="form-select form-select-lg h-100" id="to-airport" style="font-size: 1.15rem;">
              <option value="" selected>Select Location</option>
              <option value="MNL">Metro Manila</option>
              <option value="CRK">New Clark City, Tarlac</option>
              <option value="CEB">Mactan, Cebu</option>
              <option value="BTG">Batangas City</option>
            </select>
          </div>
          <!-- Trip type and guest -->
          <div class="d-flex flex-column align-items-start flex-grow-1" style="min-width: 200px;">
            <label class="form-label mb-1 fw-bold text-dark" style="font-size: 1.15rem;">Trip</label>
            <select name="trip_type" id="tripTypeSelect" class="form-select form-select-lg h-100 mb-1" style="font-size: 1.15rem; min-width: 140px;">
              <option value="oneway" selected>One-way</option>
              <option value="round">Round-trip</option>
            </select>
          </div>
          <!-- Depart field -->
          <div class="flex-grow-1 d-flex flex-column align-items-start" style="min-width: 200px;">
            <label class="form-label mb-1 fw-bold text-dark" style="font-size: 1.15rem;">Departing</label>
            <input type="date" name="depart_date" class="form-control form-control-lg h-100" value="2025-05-10" placeholder="Departing on" style="font-size: 1.15rem;">
          </div>
          <!-- Return field, only visible for round-trip -->
          <div class="flex-grow-1 d-flex flex-column align-items-start" id="return-field-container" style="min-width: 200px;">
            <label class="form-label mb-1 fw-bold text-dark" style="font-size: 1.15rem;">Return</label>
            <input type="date" name="return_date" class="form-control form-control-lg h-100" id="return-date-input" placeholder="Return" style="background: #f8f9fa; color: #888; font-size: 1.15rem;">
          </div>
        </div>
        <!-- Search flights button and 1 Guest info at the bottom, centered inside the container -->
        <div class="d-flex justify-content-center align-items-center w-100 mt-4 gap-3">
          <button type="submit" class="btn btn-primary btn-lg fw-bold px-5 py-2" style="border-radius: 12px; font-size: 1.25rem;">Search flights</button>
        </div>
      </form>
      <!-- Flight Search Box End -->
       
      </div>
    </section>

    <!-- Gallery Section (Static 3-column) -->
    <section id="gallery-section" style="padding: 2.5rem 0;">
      <h2 style="text-align: center; font-size: 2rem; font-weight: 600; margin-bottom: 2rem;">Love the Philippines</h2>
      <div class="container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem;">
        <div style="flex: 1 1 300px; max-width: 340px; min-width: 260px;">
          <img src="assets/img/home-palawan.jpeg" alt="Puerto Princesa Subterranean River National Park" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;" />
          <div style="margin-top: 1rem;">
            <div style="font-weight: 600; font-size: 1.1rem;">Puerto Princesa Subterranean River National Park</div>
            <div style="color: #888; font-size: 0.95rem; margin-top: 0.2rem;">&#169; Puerto Princesa</div>
          </div>
        </div>
        <div style="flex: 1 1 300px; max-width: 340px; min-width: 260px;">
          <img src="assets/img/popular-rice.jpg" alt="Batad Rice Terraces" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;" />
          <div style="margin-top: 1rem;">
            <div style="font-weight: 600; font-size: 1.1rem;">Batad Rice Terraces</div>
            <div style="color: #888; font-size: 0.95rem; margin-top: 0.2rem;">&#169; Banaue, Ifugao</div>
          </div>
        </div>
        <div style="flex: 1 1 300px; max-width: 340px; min-width: 260px;">
          <img src="assets/img/popular-hills.jpg" alt="Chocolate Hills" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;" />
          <div style="margin-top: 1rem;">
            <div style="font-weight: 600; font-size: 1.1rem;">Chocolate Hills</div>
            <div style="color: #888; font-size: 0.95rem; margin-top: 0.2rem;">&#169; Bohol</div>
          </div>
        </div>
        <!-- Second row of cards -->
        <div style="flex: 1 1 300px; max-width: 340px; min-width: 260px;">
          <img src="assets/img/home-elnido.jpg" alt="El Nido" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;" />
          <div style="margin-top: 1rem;">
            <div style="font-weight: 600; font-size: 1.1rem;">Big Lagoon</div>
            <div style="color: #888; font-size: 0.95rem; margin-top: 0.2rem;">&#169; El Nido, Palawan</div>
          </div>
        </div>
        <div style="flex: 1 1 300px; max-width: 340px; min-width: 260px;">
          <img src="assets/img/home-cebu.jpg" alt="Cebu" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;" />
          <div style="margin-top: 1rem;">
            <div style="font-weight: 600; font-size: 1.1rem;">Sumilon Island</div>
            <div style="color: #888; font-size: 0.95rem; margin-top: 0.2rem;">&#169; Oslob, Cebu</div>
          </div>
        </div>
        <div style="flex: 1 1 300px; max-width: 340px; min-width: 260px;">
          <img src="assets/img/home-aklan.jpg" alt="Aklan" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;" />
          <div style="margin-top: 1rem;">
            <div style="font-weight: 600; font-size: 1.1rem;"> White Beach</div>
            <div style="color: #888; font-size: 0.95rem; margin-top: 0.2rem;">&#169; Boracay Island</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Redesigned About Section -->
    <section class="about-section" id="about" style="background: #f8f9fa; padding: 3rem 0;">
      <div class="container about-flex" style="display: flex; flex-wrap: wrap; align-items: center; gap: 2rem; background: #f8f9fa; border-radius: 16px; padding: 2rem 1rem; flex-direction: row-reverse;">
        <div class="about-image" style="flex: 1; min-width: 260px; max-width: 340px; text-align: center;">
          <img src="assets/img/about-jsg.jpg" alt="JetSetGo Team" style="max-width: 320px; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); width: 100%;" />
        </div>
        <div class="about-content" style="flex: 2; min-width: 260px;">
          <h2 style="font-weight: 700; font-size: 2.2rem; color: #1e2a50;">Who We Are</h2>
          <p class="about-tagline" style="font-style: italic; color: #1e2a50; margin-bottom: 1rem;">Making travel simple, fast, and enjoyable for everyone.</p>
          <p>At JetSetGo, we believe that booking flights should be as exciting as the journey itself. Our platform brings together cutting-edge technology, real-time flight data, and a user-friendly interface to help travelers find the best flights at the best prices. From last-minute getaways to well-planned business trips, we make flying simple and stress-free.</p>
          <blockquote style="font-size: 1rem; color: #555; border-left: 4px solid #1e2a50; padding-left: 1rem; margin: 1rem 0;">
            "JetSetGo made my trip planning a breeze!"<br>
            <span style="font-size: 0.95rem; color: #888;">- Sophia R., frequent traveler</span>
          </blockquote>
          <a href="#contact" class="btn btn-primary mt-3" style="background: #198754; border: none; padding: 0.6rem 1.5rem; border-radius: 6px; color: #fff; font-weight: 600; text-decoration: none;">Contact Us</a>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
     

    <footer class="container-fluid py-5" style="background-color: #0c1a3c; color: white;">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mb-4">
            <h2 class="fw-bold">JetSetGo</h2>
            <p>JetSetGo simplifies your flight booking process with seamless payment integration, reliable billing, and an intuitive user interface. Experience a modern way to fly.</p>
            <a href="booking/booking.php" class="btn btn-success fw-bold px-4 py-2">Book Now</a>
          </div>
          <div class="col-md-6">
            <p><strong>Email</strong><br><a href="mailto:jetsetgo@gmail.com" class="text-info">jetsetgo@gmail.com</a></p>
            <p><strong>Phone</strong><br><a href="tel:+639999990000" class="text-info">(+63) 999 999 0000</a></p>
            <p><strong>Address</strong><br>Mataas Na Lupa<br>Lipa City, Batangas<br>Philippines</p>
            <div class="d-flex gap-3 mt-3">
              <a href="#"><i class="fab fa-twitter text-white fs-4"></i></a>
              <a href="#"><i class="fab fa-facebook text-white fs-4"></i></a>
              <a href="#"><i class="fab fa-instagram text-white fs-4"></i></a>
              <a href="#"><i class="fab fa-linkedin text-white fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
</footer>


    <!-- Scroll Up Button -->
    <a href="#" id="scroll-up" style="position:fixed;right:2rem;bottom:2rem;display:none;z-index:2000;background:#111;color:#fff;padding:0.5rem 0.7rem;border-radius:50%;font-size:1.5rem;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.15);"><i class="bi bi-arrow-up"></i></a>

    <script>
  // Removed old sidebar JS, now handled by main.js
</script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="admin.js">
    </script>
    <script src="assets/js/main.js"></script>

    <script>
      // Dynamic navbar color based on section
      function setNavbarColor() {
        const nav = document.querySelector('.nav');
        const home = document.getElementById('home');
        const gallery = document.getElementById('gallery-section');
        const about = document.getElementById('about');
        const hamburger = document.getElementById('nav-toggle');
        const close = document.getElementById('nav-close');
       
        const scrollY = window.scrollY;
        const homeBottom = home.offsetTop + home.offsetHeight;
        const galleryTop = gallery ? gallery.offsetTop : 0;
        const aboutTop = about ? about.offsetTop : 0;

        if (scrollY + 80 < homeBottom) {
          nav.classList.add('nav--white');
          nav.classList.remove('nav--black');
        } else if ((gallery && scrollY + 80 >= galleryTop) || (about && scrollY + 80 >= aboutTop)) {
          nav.classList.remove('nav--white');
          nav.classList.add('nav--black');
        } else {
          nav.classList.remove('nav--white');
          nav.classList.add('nav--black');
        }
      }
      window.addEventListener('scroll', setNavbarColor);
      window.addEventListener('DOMContentLoaded', setNavbarColor);
    </script>

    <style>
      .nav--white .nav__link,
      .nav--white .nav__logo,
      .nav--white .nav__toggle,
      .nav--white .nav__close {
        color: #fff !important;
      }
      .nav--black .nav__link,
      .nav--black .nav__logo,
      .nav--black .nav__toggle,
      .nav--black .nav__close {
        color: #111 !important;
      }
      .nav--white .nav__link::after,
      .nav--white .nav__link.active-link::after,
      .nav--white .nav__toggle::after,
      .nav--white .nav__close::after {
        background: #fff !important;
      }
      .nav--black .nav__link::after,
        .nav--black .nav__link.active-link::after,
      .nav--black .nav__toggle::after,
      .nav--black .nav__close::after {
        background: #111 !important;
      }
    </style>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const tripTypeSelect = document.getElementById('tripTypeSelect');
        const returnInput = document.getElementById('return-date-input');
        const fromAirport = document.getElementById('from-airport');
        const toAirport = document.getElementById('to-airport');

        // Function to validate airport selection
        function validateAirportSelection() {
          if (fromAirport.value === toAirport.value) {
            // Show error message
            Swal.fire({
              icon: 'error',
              title: 'Invalid Selection',
              text: 'Departure and arrival airports cannot be the same!',
              confirmButtonColor: '#3085d6'
            });
            // Reset the "To" selection
            toAirport.value = '';
          }
        }

        // Add validation when "To" airport changes
        if (toAirport) {
          toAirport.addEventListener('change', validateAirportSelection);
        }

        function toggleReturnFieldDisabled() {
          if (tripTypeSelect.value === 'oneway') {
            if(returnInput) returnInput.disabled = true;
          } else {
            if(returnInput) returnInput.disabled = false;
          }
        }
        if(tripTypeSelect) {
          tripTypeSelect.addEventListener('change', toggleReturnFieldDisabled);
          toggleReturnFieldDisabled(); // Initial check
        }
      });
    </script>

    <style>
      /* Responsive styles for the flight search form container and its elements */
      @media (max-width: 768px) {
        .flight-search-box {
          max-width: 98vw !important;
          margin: 12px auto 0 auto !important;
          padding: 16px 6px 16px 6px !important;
          border-radius: 12px !important;
        }
        .flight-search-box .d-flex.flex-row {
          flex-direction: column !important;
          gap: 1.2rem !important;
        }
        .flight-search-box .flex-grow-1,
        .flight-search-box .d-flex.flex-column {
          min-width: 0 !important;
          width: 100% !important;
        }
      }
      @media (max-width: 480px) {
        .flight-search-box {
          padding: 8px 2px 8px 2px !important;
          border-radius: 8px !important;
        }
        .flight-search-box label,
        .flight-search-box select,
        .flight-search-box input[type="date"] {
          font-size: 0.95rem !important;
        }
        .flight-search-box button {
          font-size: 1rem !important;
          padding: 8px 0 !important;
        }
      }
    </style>

    <style>
      /* Ensure gallery section is not hidden behind fixed header when navigated to */
      #gallery-section {
        scroll-margin-top: 100px;
      }
    </style>

    <style>
      /* Ensure about section is not hidden behind fixed header when navigated to */
      #about {
        scroll-margin-top: 100px;
      }
    </style>

    <style>
      @media (max-width: 900px) {
        .about-flex { flex-direction: column !important; text-align: center; }
        .about-content { padding-top: 1.5rem; }
      }
    </style>

    <style>
      .footer {
        background: #0c1a3c;
        color: #fff;
        padding: 4rem 0 0 0;
        margin-top: 2rem;
      }

      .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
      }

      .footer-brand {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-bottom: 3rem;
        flex-direction: row;
        text-align: left;
      }

      .footer-logo {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #fff;
        padding: 8px;
      }

      .brand-text {
        text-align: left;
      }

      .brand-text h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
      }

      .brand-text p {
        color: #a0aec0;
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
      }

      .footer-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
        justify-items: start;
        text-align: left;
      }

      .footer-section h4 {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
      }

      .footer-section h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -8px;
        width: 40px;
        height: 2px;
        background: #ffd700;
      }

      .footer-links {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        align-items: flex-start;
      }

      .footer-links a {
        color: #a0aec0;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
      }

      .footer-links a:hover {
        color: #ffd700;
        transform: translateX(5px);
      }

      .footer-contact {
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }

      .footer-contact div {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: #a0aec0;
        font-size: 0.95rem;
      }

      .footer-contact i {
        color: #ffd700;
        font-size: 1.1rem;
      }

      .footer-social {
        display: flex;
        gap: 1.2rem;
      }

      .footer-social a {
        color: #a0aec0;
        font-size: 1.3rem;
        transition: all 0.3s ease;
      }

      .footer-social a:hover {
        color: #ffd700;
        transform: translateY(-3px);
      }

      .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1.5rem 0;
      }

      .footer-bottom-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
      }

      .footer-bottom p {
        color: #a0aec0;
        font-size: 0.9rem;
        margin: 0;
      }

      .footer-bottom-links {
        display: flex;
        gap: 1.5rem;
      }

      .footer-bottom-links a {
        color: #a0aec0;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
      }

      .footer-bottom-links a:hover {
        color: #ffd700;
      }

      @media (max-width: 768px) {
        .footer {
          padding: 3rem 0 0 0;
        }

        .footer-brand {
          flex-direction: row;
          text-align: left;
          align-items: flex-start;
        }

        .brand-text {
          text-align: left;
        }

        .footer-grid {
          gap: 2rem;
          justify-items: start;
          text-align: left;
        }

        .footer-section {
          text-align: left;
        }

        .footer-section h4::after {
          left: 50%;
          transform: translateX(-50%);
        }

        .footer-links {
          align-items: flex-start;
        }

        .footer-contact div {
          justify-content: center;
        }

        .footer-social {
          justify-content: center;
        }

        .footer-bottom-content {
          flex-direction: column;
          text-align: center;
        }

        .footer-bottom-links {
          justify-content: center;
        }
      }

      /* Footer Contact Info & Social Styles */
      .footer-contact-block {
        margin-bottom: 1.2rem;
      }
      .footer-contact-label {
        font-weight: bold;
        color: #fff;
        margin-bottom: 0.2rem;
      }
      .footer-contact-link {
        color: #4db3fa;
        text-decoration: underline;
        font-size: 1.05rem;
        word-break: break-all;
        display: inline-block;
        margin-bottom: 0.2rem;
        transition: color 0.2s;
      }
      .footer-contact-link:hover {
        color: #ffd700;
        text-decoration: underline;
      }
      .footer-contact-address {
        color: #fff;
        font-size: 1.05rem;
        line-height: 1.4;
        margin-top: 0.2rem;
      }
      .footer-social-row {
        display: flex;
        gap: 0.7rem;
        margin-top: 0.7rem;
      }
      .footer-social-row a {
        color: #fff;
        background: #19284a;
        border-radius: 6px;
        padding: 4px 7px;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        transition: background 0.2s, color 0.2s;
      }
      .footer-social-row a:hover {
        color: #ffd700;
        background: #223366;
      }
      @media (max-width: 768px) {
        .footer-grid {
          grid-template-columns: 1fr;
        }
        .footer-section.contact-section {
          margin-bottom: 2rem;
        }
      }
    </style>

    <style>
      .footer-section.contact-section {
        background: #0c1a3c !important;
        border-radius: 12px;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        color: #fff;
        box-shadow: none;
      }
    </style>

    <!-- Newsletter Subscription Styles -->
    <style>
      .newsletter-section {
        background: #0c1a3c;
        border-radius: 10px;
        padding: 2.2rem 2rem 2rem 2rem;
        color: #fff;
        max-width: 340px;
        min-width: 260px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-left: auto;
      }
      .newsletter-title {
        font-size: 2.3rem;
        font-weight: 700;
        margin: 0 0 1.1rem 0;
        line-height: 1.1;
        color: #fff;
      }
      .newsletter-desc {
        font-size: 1.05rem;
        color: #cfd8e3;
        margin-bottom: 1.2rem;
        margin-top: 0;
      }
      .newsletter-form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }
      .newsletter-input {
        width: 100%;
        padding: 0.9rem 1rem;
        border: none;
        border-radius: 4px;
        background: #16244a;
        font-size: 1.05rem;
        color: #fff;
        margin-bottom: 0.2rem;
        outline: none;
        transition: box-shadow 0.2s;
      }
      .newsletter-input::placeholder {
        color: #b0b8c9;
        opacity: 1;
      }
      .newsletter-input:focus {
        box-shadow: 0 0 0 2px #ffd70055;
      }
      .newsletter-btn {
        width: 100%;
        padding: 1rem 0.5rem;
        background: #223366;
        color: #fff;
        font-size: 1.1rem;
        font-weight: 500;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: background 0.2s, color 0.2s;
      }
      .newsletter-btn:hover {
        background: #ffd700;
        color: #0c1a3c;
      }
      .newsletter-arrow {
        font-size: 1.3rem;
        margin-left: 0.7rem;
        transition: margin-left 0.2s;
      }
      .newsletter-btn:hover .newsletter-arrow {
        margin-left: 1.2rem;
      }
      @media (max-width: 900px) {
        .footer-grid {
          grid-template-columns: 1fr;
        }
        .newsletter-section {
          margin: 2rem auto 0 auto;
          max-width: 98vw;
        }
      }
    </style>

    <style>
      @media (max-width: 900px) {
        .footer-grid {
          grid-template-columns: 1fr;
          justify-items: center;
          text-align: center;
        }
        .footer-section.quick-links-section,
        .newsletter-section {
          align-items: center;
          text-align: center;
        }
      }
    </style>

    <style>
      @media (max-width: 900px) {
        .about-section, .contact-section {
          text-align: center !important;
          align-items: center !important;
          justify-content: center !important;
        }
        .about-section .btn,
        .contact-section .btn {
          margin-left: auto;
          margin-right: auto;
          display: block;
        }
        .footer-social,
        .footer-social-row {
          justify-content: center !important;
        }
      }
    </style>

    <style>
      @media (max-width: 900px) {
        .container-fluid.py-5,
        .container-fluid.py-5 .container,
        .container-fluid.py-5 .row,
        .container-fluid.py-5 .col-md-6 {
          text-align: center !important;
          align-items: center !important;
          justify-content: center !important;
        }
        .container-fluid.py-5 .btn {
          margin-left: auto;
          margin-right: auto;
          display: block;
          float: none;
        }
        .container-fluid.py-5 .d-flex.gap-3.mt-3 {
          justify-content: center !important;
        }
      }
    </style>
  </body>
</html>
