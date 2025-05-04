<?php
    session_start();

    require_once '../database/admin-crud.php';
    require_once '../database/booking-crud.php';

      // Redirect to login if not logged in
      if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
          header("Location: ../login.php");
          exit;
      }

      $user = new Crud();
    $bookingUser = new BookingCrud();
    $editingUser = null;
    $allBookings = $user->getAllBookings();
    $allPassengers = $user->getAllPassengers();

    $guestDetails = [];
foreach ($allPassengers as $passenger) {
    $bookingId = $passenger['booking_id'];
    if (!isset($guestDetails[$bookingId])) {
        $guestDetails[$bookingId] = [];
    }
    $guestDetails[$bookingId][] = $passenger;
}
    // $updateBookings = $user->upa
    $allFlights = $user->getAllFlights();
    $allAirports = $user->getAllAirports();
    $allAvailablePlanes = $user->getAllAvailablePlanes();


    if (isset($_POST['delete'])) {

 
        $user->deleteBookings($_POST['deleteBookingId']);
        header("Location: bookings.php?success=1");
        exit;
      }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Bootstrap CSS  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Bootstrap Icons CDN  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- SweetAlert2 CDN  -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="admin.css">

        <!-- for debugging  -->
        <script>
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                alert("Error: " + msg + " in " + url + " at line " + lineNo);
                return false;
            };
        </script>

        <title>JetSetGo | Dashboard</title>

    </head>
<body>

    <?php include 'includes/sidebar.php'; ?>

    <section class="home-section">

        <?php include 'includes/navbar.php'; ?>

        <div style="margin-left: 10px; padding: 20px;">
            <h2>Bookings</h2>


        <div class="container mt-4">
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center align-middle table-bordered">
                        <thead class="table-light fw-bold">
                            <tr>
                                <th>#</th>
                                <th>Booking ID</th>
                                <th>Booking Date</th>
                                <th>Flight ID</th>
                                <th>Flight Date</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>Plane</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php 
                            $count = 1;
                            foreach ($allBookings as $u): ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= htmlspecialchars($u['booking_id']) ?></td>
                                    <td><?= htmlspecialchars($u['booking_date']) ?></td>
                                    <td><?= htmlspecialchars($u['flight_id']) ?></td>
                                    <td><?= htmlspecialchars($u['flight_date']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($u['dep_airportcode']) ?> - <?= htmlspecialchars($u['dep_airportlocation']) ?><br>
                                        <span class="text-muted"><?= htmlspecialchars($u['dep_time']) ?></span>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($u['arr_airportcode']) ?> - <?= htmlspecialchars($u['arr_airportlocation']) ?><br>
                                        <span class="text-muted"><?= htmlspecialchars($u['arr_time']) ?></span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($u['plane_code']) ?></strong><br>
                                        <img src="<?= htmlspecialchars($u['plane_photo']) ?>" alt="Plane" style="max-height: 50px;">
                                    </td>
                                    <td>$<?= number_format($u['price'], 2) ?></td>
                                    <td class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewBookings<?= $u['booking_id'] ?>">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBookings<?= $u['booking_id'] ?>">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form method="post" class="d-inline" onsubmit="return confirm('Delete this booking?');">
                                            <input type="hidden" name="deleteBookingId" value="<?= $u['booking_id'] ?>">
                                            <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                    <!-- VIEW BOOKING MODAL -->
                                    <div class="modal fade" id="viewBookings<?= $u['booking_id'] ?>">
                                        <div class="modal-dialog modal-dialog-centered" style="max-width: 1100px;"> 
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header" style="background-color: #0d1b6c;">
                                                    <h4 class="modal-title text-white">View Booking Details</h4>
                                                </div>

                                                <div class="modal-body">
                                                    <!-- Plane Details at the Top -->
                                                    <div class="row align-items-center mb-4">
                                                        <!-- Plane Image -->
                                                        <div class="col-md-5 text-center">
                                                            <div class="flex-shrink-0">
                                                                <img 
                                                                    src="<?= htmlspecialchars($u['plane_photo']) ?>" 
                                                                    alt="Plane Image" 
                                                                    class="img-fluid rounded shadow view_plane_image" 
                                                                    style="width: 250px; height: 170px; margin-top: 30px;">
                                                            </div>
                                                        </div>

                                                        <!-- Plane Details -->
                                                        <div class="col-md-7">
                                                            <div class="mb-3">
                                                                <label>Plane Number</label>
                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($u['plane_code']) ?>" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Price</label>
                                                                <input type="text" class="form-control" value="$<?= number_format($u['price'], 2) ?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Booking Details -->
                                                    <h5 class="fw-bold mt-4">Booking Details</h5>
                                                    <hr>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label>Booking ID</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($u['booking_id']) ?>" disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Booking Date</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($u['booking_date']) ?>" disabled>
                                                        </div>
                                                    </div>

                                                <!-- Flight Details -->
                                                    <h5 class="fw-bold mt-4">Flight Details</h5>
                                                    <hr>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label>Flight ID</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($u['flight_id']) ?>" disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Flight Date</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($u['flight_date']) ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label>Departure</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($u['dep_airportcode']) ?> - <?= htmlspecialchars($u['dep_airportlocation']) ?> (<?= htmlspecialchars($u['dep_time']) ?>)" disabled>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Arrival</label>
                                                            <input type="text" class="form-control" value="<?= htmlspecialchars($u['arr_airportcode']) ?> - <?= htmlspecialchars($u['arr_airportlocation']) ?> (<?= htmlspecialchars($u['arr_time']) ?>)" disabled>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Price</label>
                                                            <input type="text" class="form-control" value="$<?= number_format($u['price'], 2) ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <h5 class="fw-bold mt-4">Passenger Info</h5>
                                                    <hr>
                                                    <?php if (!empty($guestDetails[$u['booking_id']])): ?>
                                                        <?php foreach ($guestDetails[$u['booking_id']] as $index => $guest): ?>
                                                            <div class="border rounded p-3 mb-4 shadow-sm">
                                                                <h6 class="text-primary">Passenger <?= $index + 1 ?></h6>
                                                                <div class="row mb-3">
                            
                                                                <div class="col-md-2">
                                                                    <label>Title</label>
                                                                    <input type="text" class="form-control" value="<?= htmlspecialchars($guest['title']) ?>" disabled>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label>First Name</label>
                                                                    <input type="text" class="form-control" value="<?= htmlspecialchars($guest['first_name']) ?>" disabled>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label>Last Name</label>
                                                                    <input type="text" class="form-control" value="<?= htmlspecialchars($guest['last_name']) ?>" disabled>
                                                                </div>
                                                            </div>

                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label>Date of Birth</label>
                                                                        <input type="text" class="form-control" value="<?= htmlspecialchars($guest['date_of_birth']) ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Contact Number</label>
                                                                        <input type="text" class="form-control" value="<?= htmlspecialchars($guest['contact_number']) ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Nationality</label>
                                                                        <input type="text" class="form-control" value="<?= htmlspecialchars($guest['nationality']) ?>" disabled>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label>Email</label>
                                                                    <input type="text" class="form-control" value="<?= htmlspecialchars($guest['email']) ?>" disabled>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div class="text-center text-muted">No passenger data available for this booking.</div>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL -->

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>



    </section>

<!-- --------------------------------------------- --> 

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- JAVASCRIPT --> 
    <script src="admin-js.js"></script>



</body>
</html>