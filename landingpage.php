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

    <!-- Font Awesome (Optional if using FA icons) -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    <link rel="stylesheet" href="style.css" />

    <style>
      body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        overflow: auto;
      }

      html {
        scroll-behavior: smooth;
      }

      .hero-section {
        background-image: url('assets/bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        position: relative;
        color: white;
        margin-bottom: -5px;
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

      .carousel {
        margin-top: -5px;
      }

      .carousel-inner {
        max-height: 750px;
      }

      .carousel-inner img {
        height: 750px;
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
        background: url('assets/bg2.png') no-repeat center center;
        background-size: cover;
        background-color: #0c1a3c;
    
        padding: 100px 0 40px;
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

      .contact-header {
        background: url('assets/bg2.png') no-repeat center center;
        background-size: cover;
        background-color: #0c1a3c;
        padding: 80px 0;
        color: white;
      }

      .contact-header h1 {
        font-size: 3rem;
        font-weight: bold;
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
          <li class="nav-item"><a class="btn btn-darkblue" href="#">LOGIN</a></li>
        </ul>
      </nav>

      <!-- Hero Content -->
      <div class="hero-content text-white">
        <h1 class="display-4 fw-bold">Streamlining flight<br />reservation</h1>
        <a href="#" class="btn btn-darkblue mt-3 px-4 py-2">LEARN MORE</a>
      </div>
    </section>

    <!-- Carousel Section -->
    <section id="gallery-carousel" class="carousel slide carousel-fade carousel-dark" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#gallery-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#gallery-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#gallery-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/gallery1.png" class="d-block w-100" alt="Scenic view of Puerto Princesa beach" />
          <div class="carousel-caption d-none d-md-block">
            <h5>Discover a new Experience</h5>
            <p>Puerto Princesa, Palawan</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/gallery2.webp" class="d-block w-100" alt="Chocolate Hills in Cebu" />
          <div class="carousel-caption d-none d-md-block">
            <h5>Discover a new Experience</h5>
            <p>Chocolate Hills, Cebu</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/gallery3.jpg" class="d-block w-100" alt="Boracay Beach with white sand" />
          <div class="carousel-caption d-none d-md-block">
            <h5>Discover a new Experience</h5>
            <p>Boracay, Aklan</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#gallery-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#gallery-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </section>

    <!-- Who We Are Section -->
    <section class="about-header" id="about">
      <div class="container">
        <h1>JetSetGo</h1>
      </div>
    </section>

    <section class="about-section">
      <div class="container">
        <h4 class="fw-bold mb-3">Who We Are</h4>
        <p>
          At JetSetGo, we believe that booking flights should be as exciting as the journey itself. Our platform brings together cutting-edge technology, real-time flight data, and a user-friendly interface to help travelers find the best flights at the best prices. From last-minute getaways to well-planned business trips, we make flying simple and stress-free.
        </p>
      </div>
    </section>

    <!-- Contact Header -->
    <section class="contact-header">
      <div class="container">
        <h1>Contact Us</h1>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="container contact-section">
      <div class="row text-center text-md-start">
        <div class="col-md-3 mb-4">
          <h5>Chat (24/7)</h5>
          <p><i class="fab fa-facebook-messenger"></i> <strong>JetSetGo</strong></p>
          <p><i class="fab fa-facebook"></i> facebook.com/JetSetGo</p>
        </div>
        <div class="col-md-3 mb-4">
          <h5>Email</h5>
          <p>jetsetgo@example.com</p>
        </div>
        <div class="col-md-3 mb-4">
          <h5>Call Us</h5>
          <p>63+ 099-1234-567</p>
        </div>
        <div class="col-md-3 mb-4">
          <h5>Stay Connected</h5>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-x-twitter"></i></a>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer d-flex justify-content-center align-items-center mt-5">
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
