<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>JetSetGo</title>
    <!-- MDB icon -->
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <!-- Google Fonts Roboto -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
    />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    <style>
      .hero-section {
        background-image: url('bg.png'); 
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
        background-color: #1E2A50;
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
  <body>
    <!-- Start your project here -->
    <div class="hero-section">
      <div class="hero-overlay"></div>

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark px-5">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="logo.png" alt="Logo" width="30" class="me-2">
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
        <h1 class="display-4 fw-bold">Streamlining flight<br>reservation</h1>
        <a href="#" class="btn btn-darkblue mt-3 px-4 py-2">LEARN MORE</a>
      </div>
    </div>

    

    <!-- Carousel wrapper -->
    <div id="gallery-carousel" class="carousel slide carousel-fade carousel-dark" data-mdb-ride="carousel" data-mdb-carousel-init>
      <div id="gallery-carousel" class="carousel slide carousel-fade carousel-dark" 
     data-mdb-ride="carousel" 
     data-mdb-carousel-init 
     data-mdb-interval="3000">

  <!-- Indicators -->
  <div class="carousel-indicators">
    <button
      data-mdb-target="#carouselDarkVariant"
      data-mdb-slide-to="0"
      class="active"
      aria-current="true"
      aria-label="Slide 1"
    ></button>
    <button
      data-mdb-target="#carouselDarkVariant"
      data-mdb-slide-to="1"
      aria-label="Slide 1"
    ></button>
    <button
      data-mdb-target="#carouselDarkVariant"
      data-mdb-slide-to="2"
      aria-label="Slide 1"
    ></button>
  </div>

  <!-- Inner -->
  <div class="carousel-inner">
    <!-- Single item -->
    <div class="carousel-item active">
      <img src="gallery1.png" class="d-block w-100" alt="Motorbike Smoke"/>
      <div class="carousel-caption d-none d-md-block">
        <h5>Discover a new Experience</h5>
        <p>Puerto Princesa, Palawan</p>
      </div>
    </div>

    <!-- Single item -->
    <div class="carousel-item">
      <img src="gallery2.webp" class="d-block w-100" alt="Mountaintop"/>
      <div class="carousel-caption d-none d-md-block">
        <h5>Discover a new Experience</h5>
        <p>Chocolate Hills, Cebu</p>
      </div>
    </div>

    <!-- Single item -->
    <div class="carousel-item">
      <img src="gallery3.jpg" class="d-block w-100" alt="Woman Reading a Book"/>
      <div class="carousel-caption d-none d-md-block">
        <h5>Discover a new Experience</h5>
        <p>Boracay, Aklan</p>
      </div>
    </div>
  </div>

  
  <!-- Inner -->

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<section class="info-section py-5 px-4 text-white" style="background-color: #1e2a50;">
      <div class="container">
        <h2 class="mb-4">Why Choose JetSetGo?</h2>
        <p>
          JetSetGo simplifies your flight booking process with seamless payment integration,
          reliable billing, and an intuitive user interface. Experience a modern way to fly.
        </p>
      </div>
    </section>
<!-- Carousel wrapper -->


    <!-- End your project here -->

    <!-- MDB -->
    <script type="text/javascript" src="js/mdb.umd.min.js"></script>
    
  </body>
</html>




