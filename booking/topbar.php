<?php include 'bookingmodals.php'; ?>


<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
  <div class="container-fluid d-flex align-items-center">


    <span class="navbar-brand">
      <img src="your-logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-center">
      JetSetGo
    </span>

    <button class="btn btn-outline-light ms-auto" id="cancelBookingBtn">
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



<script>
document.getElementById('cancelBookingBtn').addEventListener('click', function () {
  Swal.fire({
    title: 'Are you sure?',
    text: "This will cancel your booking and cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, cancel it!',
    cancelButtonText: 'No, keep it'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'cancel_booking.php';
    }
  });
});
</script>
