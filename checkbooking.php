<?php

  session_start();


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_SESSION['homepage'] = true;

      header('Location: booking.php');

      exit();
  }

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>JetSetGo</title>
    <meta name="description" content="JetSetGo - Streamlining your flight booking experience with simplicity and speed." />
    <meta name="keywords" content="flight, booking, travel, JetSetGo, airline, Philippines" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />


    <style>
      body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        overflow: hidden;
        min-height: 100vh;
        flex-direction: column;
        display: flex;
      }

      html {
        scroll-behavior: smooth;
      }

      
      .hero-section {
        background-image: url('assets/bg.png');
        background-size: cover;
        background-position: top;
        background-repeat: no-repeat;
        min-height: 8vh;
        position: relative;
        color: white;
        margin-bottom: -5px;
      }

      .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 15%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
        pointer-events: none;
      }

      nav.navbar {
        position: relative;
        z-index: 3;
      }

      .hero-content {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 50%;
        transform: translate(-80%, -50%);
        text-align: left;
        padding: 20px;
        max-width: 800px;
        width: 90%;
      }

      .btn-darkblue {
        background-color: #1e2a50;
        color: white;
      }

      .btn-darkblue:hover {
        background-color: #2f3d6c;
        color: white;
      }

      footer {
        margin-top: auto;
        text-align: center;
        background-color: #0c1a3c;
        padding: 10px;
        }

      .footer img {
        height: 30px;
        margin-right: 10px;
      }
    </style>
  </head>

  <body>

      <!-- Hero Section -->
      <section class="hero-section" id="home">
      <div class="hero-overlay"></div>

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark px-5">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="assets/logo.png" alt="JetSetGo Logo" width="30" class="me-2" />
          JetSetGo
        </a>
        <ul class="navbar-nav ms-auto d-flex flex-row gap-4">
          <li class="nav-item"><a class="nav-link text-white" href="#home">HOME</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#gallery-carousel">GALLERY</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#about">ABOUT</a></li>
          <li class="nav-item"><a class="btn btn-darkblue" href="login.php">LOGIN</a></li>
        </ul>
      </nav>

    </section>

    <div class="container my-4 mt-5 pt-5 d-flex justify-content-center align-items-center">
        <div class="w-100" style="max-width: 500px;">
            <div class="bg-white shadow rounded mb-4 overflow-hidden">
                <div class="p-4">
                    <div class="row mb-2">
                        <div class="text-center mb-6">
                            <h2>Manage Booking</h2>
                            <p class="text-secondary mb-0 small mb-3">Type in your details to check your booking</p>
                        </div>

                        <form action="checkbooking.php" method="POST">
                            <div class="mb-3">
                                <label for="bookReference" class="form-label">Booking Reference Number</label>
                                <input type="text" id="bookReference" name="book_ref" class="form-control" placeholder="Booking Reference Number" required>
                            </div>
                        </form>

                            <div class="mb-4">
                                <label for="identifier" class="form-label">Last Name or Email Address</label>
                                <input type="text" id="lastNameEmail" name="name_email" class="form-control" placeholder="Enter your last name or email address" required>
                            </div>

                            <button type="submit" class="btn btn-primary" style="max-width: 95%; margin-left: 12px;">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer d-flex justify-content-center align-items-center text-white">
      <img src="assets/logo.png" alt="JetSetGo Logo" class="rounded-circle" />
      <span>JetSetGo 2025</span>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <script src="admin.js"></script>
  </body>
</html>