<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- Bootstrap Icons CDN -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <title>JetSetGo</title>
    <link rel="stylesheet" href="style.css" />

    <style>
      .hero-section {
        background-image: url('assets/bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        position: relative;
        color: white;
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
        left: 30%;
        transform: translate(-50%, -50%);
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

      body {
        overflow: auto;
      }

      html {
        scroll-behavior: smooth;
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
      }
    </style>
  </head>

  <body style="margin: 0">
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-overlay"></div>

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark px-5">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="assets/logo.png" alt="JetSetGo Logo" width="30" class="me-2" />
          JetSetGo
        </a>
        <div class="ms-auto d-flex align-items-center gap-4">
          <a class="nav-link text-white" href="#">HOME</a>
          <a class="nav-link text-white" href="#gallery-carousel">GALLERY</a>
          <a class="nav-link text-white" href="#">ABOUT</a>
          <a class="btn btn-darkblue" href="#">LOGIN</a>
        </div>
      </nav>

      <!-- Hero Content -->
      <div class="hero-content text-white">
        <h1 class="display-4 fw-bold">Streamlining flight<br />reservation</h1>
        <a href="#" class="btn btn-darkblue mt-3 px-4 py-2">LEARN MORE</a>
      </div>
    </div>

    <!-- Carousel Section -->
    <div
      id="gallery-carousel"
      class="carousel slide carousel-fade carousel-dark"
      data-bs-ride="carousel"
      data-bs-interval="3000"
    >
      <!-- Indicators -->
      <div class="carousel-indicators">
        <button
          type="button"
          data-bs-target="#gallery-carousel"
          data-bs-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-bs-target="#gallery-carousel"
          data-bs-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-bs-target="#gallery-carousel"
          data-bs-slide-to="2"
          aria-label="Slide 3"
        ></button>
      </div>

      <!-- Inner Carousel -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img
            src="assets/gallery1.png"
            class="d-block w-100"
            alt="Puerto Princesa"
          />
          <div class="carousel-caption d-none d-md-block">
            <h5>Discover a new Experience</h5>
            <p>Puerto Princesa, Palawan</p>
          </div>
        </div>
        <div class="carousel-item">
          <img
            src="assets/gallery2.webp"
            class="d-block w-100"
            alt="Chocolate Hills"
          />
          <div class="carousel-caption d-none d-md-block">
            <h5>Discover a new Experience</h5>
            <p>Chocolate Hills, Cebu</p>
          </div>
        </div>
        <div class="carousel-item">
          <img
            src="assets/gallery3.jpg"
            class="d-block w-100"
            alt="Boracay Beach"
          />
          <div class="carousel-caption d-none d-md-block">
            <h5>Discover a new Experience</h5>
            <p>Boracay, Aklan</p>
          </div>
        </div>
      </div>

      <!-- Controls -->
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#gallery-carousel"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#gallery-carousel"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Info Section -->
    <section class="info-section py-5 px-4 text-white" style="background-color: #1e2a50">
      <div class="container">
        <h2 class="mb-4">Why Choose JetSetGo?</h2>
        <p>
          JetSetGo simplifies your flight booking process with seamless payment integration,
          reliable billing, and an intuitive user interface. Experience a modern way to fly.
        </p>
      </div>
    </section>

    <!-- Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <script src="admin.js"></script>
  </body>
</html>
