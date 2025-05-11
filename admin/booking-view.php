<?php
session_start();

require_once '../database/admin-crud.php';

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

$crud = new Crud();
$booking_id = $_POST['booking_id'] ?? null;
$allPassengers = $crud->getAllPassengers();

$guestDetails = [];
foreach ($allPassengers as $passenger) {
    $bookingId = $passenger['booking_id'];
    if (!isset($guestDetails[$bookingId])) {
        $guestDetails[$bookingId] = [];
    }
    $guestDetails[$bookingId][] = $passenger;
}

if ($booking_id) {
    $bookings = $crud->getAllBookings(); 
    $booking = null;

    foreach ($bookings as $b) {
        if ($b['booking_id'] == $booking_id) {
            $booking = $b;
            break;
        }
    }

    if (!$booking) {
        echo "Booking not found.";
        exit;
    }

    $passengers = $crud->getAllPassengers();
    $matched_passengers = [];

    foreach ($passengers as $p) {
        if ($p['booking_id'] == $booking_id) {
            $matched_passengers[] = $p;
        }
    }


} else {
    echo "No booking ID specified.";
    exit;
}


if ($booking_id) {
    $payments = $crud->getAllPayments();
    $paymentInfo = null;

    foreach ($payments as $p) {
        if ($p['booking_id'] == $booking_id) {
            $paymentInfo = $p;
            break;
        }
    }

    

    if (!$paymentInfo) {
        echo "Payment not found.";
        exit;
    }

} else {
    echo "No booking ID specified.";
    exit;
}



// Redirect to login if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}

$showSuccess = false;
$username = $_SESSION["username"];

if (isset($_SESSION["login_success"])) {

    $showSuccess = true;

    unset($_SESSION["login_success"]);
}

$passengerDetails = [];

if (isset($flight_id, $flight['departure_location'], $flight['arrival_location'])) {
    $passengerDetails = $crud->viewGuestsByFlight($flight_id, $flight['departure_location'], $flight['arrival_location']);
} else {
    echo "Required parameters missing.";
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

    <title>JetSetGo | ViewFlights </title>

</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <section class="home-section">

        <?php include 'includes/navbar.php'; ?>


        <!-- Flights breadcrumb section -->

        <nav aria-label="breadcrumb" class="ms-4 mt-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="bookings.php">Booking</a></li>
                <li class="breadcrumb-item active" aria-current="page">Booking#<?= htmlspecialchars($booking_id) ?></li>

            </ol>
        </nav>

        <!-- Booking and Flight Section -->
        <div class="container mt-4">
            <div class="row">
                <!-- Left Box: Booking Details and Additional Form -->
                <div class="col-md-6">
                    <!-- Booking Details -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="mb-3" style="font-size: 1.3rem;">Booking Details</h4>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>BOOKING ID</label>
                                    <input type="text" class="form-control" value="<?= $booking['booking_id'] ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>BOOKING DATE</label>
                                    <input type="text" class="form-control" value="<?= $booking['booking_date'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="row g-2" style="font-size: 1.3rem;">PAYMENT DETAILS</h4>
                            <hr>
                           <div class="row mb-2">
                                <div class="col-md-6">
                                    <label>MODE OF PAYMENT</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($paymentInfo['payment_type'])?>"   disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>NAME</label>
                                    <input type="text" class="form-control"
                                        value="<?= htmlspecialchars(
                                            $paymentInfo['payment_type'] === 'on-site' 
                                                ? $paymentInfo['onsite_name'] 
                                                : $paymentInfo['card_name']
                                        ) ?>" 
                                        disabled>

                                </div>
                                <div class="col-md-6">
                                    <label>CARD/ID NUMBER</label>
                                    <input type="text" class="form-control"
                                        value="<?= htmlspecialchars(
                                            $paymentInfo['payment_type'] === 'on-site' 
                                                ? $paymentInfo['onsite_validID'] 
                                                : $paymentInfo['card_number']
                                        ) ?>" 
                                        disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>STATUS</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($paymentInfo['payment_status'])?>"   disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Box: Plane Details -->
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="mb-3" style="font-size: 1.3rem;">Flight Details</h4>
                            <hr>

                            <div class="row">
                                <!-- Left Side: Form Fields -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">FLIGHT ID</label>
                                        <input type="text" class="form-control" value="<?= $booking['flight_id'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">FLIGHT DATE</label>
                                        <input type="text" class="form-control" value="<?= $booking['flight_date'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">DEPARTURE</label>
                                        <input type="text" class="form-control" value="<?= $booking['dep_airportcode'] ?> - <?= $booking['dep_airportlocation'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">ARRIVAL</label>
                                        <input type="text" class="form-control" value="<?= $booking['arr_airportcode'] ?> - <?= $booking['arr_airportlocation'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">PRICE</label>
                                        <input type="text" class="form-control" value="₱ <?= number_format($booking['price'], 2) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Right Side: Plane Image -->
                                <div class="col-md-6 d-flex align-items-center justify-content-center">
                                    <img src="<?= htmlspecialchars($booking['plane_photo']) ?>"
                                        alt="Plane Image"
                                        class="img-fluid rounded shadow"
                                        style="width: 250px; height: 140px; object-fit: cover;">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- END of .row -->



            <!-- Passengers Title Section with Flight Route -->
            <div class="container mt-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="mb-3" style="font-size: 1.3rem;">
                            Passengers Info
                        </h4>

                        <!-- Passenger Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light text-center">
                                    <tr>

                                        <th>Title</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Date of Birth</th>
                                        <th>Contact Number</th>
                                        <th>Nationality</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if (!empty($guestDetails[$booking_id])) : ?>
                                        <?php foreach ($guestDetails[$booking_id] as $passenger) : ?>
                                            <tr>

                                                <td><?= htmlspecialchars($passenger['title']) ?></td>
                                                <td><?= htmlspecialchars($passenger['first_name']) ?></td>
                                                <td><?= htmlspecialchars($passenger['last_name']) ?></td>
                                                <td><?= htmlspecialchars($passenger['date_of_birth']) ?></td>
                                                <td><?= htmlspecialchars($passenger['contact_number']) ?></td>
                                                <td><?= htmlspecialchars($passenger['nationality']) ?></td>
                                                <td><?= htmlspecialchars($passenger['email']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="9">No passengers found for this flight.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</body>