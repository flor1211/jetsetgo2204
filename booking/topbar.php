<?php include 'bookingmodals.php'; ?>



<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
  <div class="container-fluid d-flex align-items-center">


    <span class="navbar-brand">
      <img src="your-logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-center">
      JetSetGo
    </span>

    <button class="btn btn-outline-light ms-auto" data-bs-toggle="modal" data-bs-target="#cancelbookingModal">
      <i class="bi bi-box-arrow-left"></i> Cancel Booking
    </button>


  </div>
</nav>

<style>
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
