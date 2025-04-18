<?php include 'bookingmodals.php'; ?>



<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
  <div class="container-fluid d-flex align-items-center">


    <span class="navbar-brand">
      <img src="../assets/jsglogo.webp" alt="Logo"style="height:auto;" width="50">
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
        margin-left: 20px;
        color: white;
        white-space: nowrap; 
    }

    .btn {
        margin-right: 20px;
    }

    .container-fluid {
        display: flex;
        justify-content: space-between; 
        align-items: center; 
        width: 100%;
    }
</style>
