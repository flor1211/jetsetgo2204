<?php
session_start();

require_once '../database/admin-crud.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

$crud = new Crud();

$flight_id = $_POST['flight_id'] ?? null;


if ($flight_id) {
    $flights = $crud->getAllFlights();
    $flight = null;

    foreach ($flights as $f) {
        if ($f['flight_id'] == $flight_id) {
            $flight = $f;
            break;
        }
    }

    if (!$flight) {
        echo "Flight not found.";
        exit;
    }
} else {
    echo "No flight ID specified.";
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
                <li class="breadcrumb-item"><a href="flights.php">Flights</a></li>
                <li class="breadcrumb-item active" aria-current="page">Flight#<?= htmlspecialchars($flight_id) ?></li>

            </ol>
        </nav>

        <!-- Plane and Flight Section -->
        <div class="container mt-4">
            <div class="row">
                <!-- Left Box: Flight Details -->
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="mb-3" style="font-size: 1.3rem;">Flight Details</h4>
                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>DEPARTURE LOCATION</label>
                                    <input type="text" class="form-control" value="<?= $flight['departure_code'] ?> - <?= $flight['departure_location'] ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>ARRIVAL LOCATION</label>
                                    <input type="text" class="form-control" value="<?= $flight['arrival_code'] ?> - <?= $flight['arrival_location'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>DEPARTURE TIME</label>
                                    <input type="time" class="form-control" value="<?= $flight['departure_time'] ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>ARRIVAL TIME</label>
                                    <input type="time" class="form-control" value="<?= $flight['arrival_time'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>DATE</label>
                                    <input type="date" class="form-control" value="<?= $flight['date'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Box: Plane Details -->
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4 class="mb-3" style="font-size: 1.3rem;">Plane Details</h4>
                            <hr>

                            <div class="row">
                                <!-- Left Side: Form Fields -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">PLANE CODE</label>
                                        <input type="text" class="form-control" value="<?= $flight['plane_code'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">NUMBER OF SEATS</label>
                                        <input type="text" class="form-control" value="<?= $flight['numofseats'] ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label style="font-size: 0.9rem;">PRICE</label>
                                        <input type="text" class="form-control" value="₱ <?= number_format($flight['price'], 2) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Right Side: Plane Image -->
                                <div class="col-md-6 d-flex align-items-center justify-content-center">
                                    <img src="<?= htmlspecialchars($flight['plane_photo']) ?>"
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
                            Passengers of <?= htmlspecialchars($flight['departure_location']) ?> - <?= htmlspecialchars($flight['arrival_location']) ?>
                        </h4>

                        <!-- Passenger Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Full Name</th>
                                        <th>Date of Birth</th>
                                        <th>Contact Number</th>
                                        <th>Nationality</th>
                                        <th>Email</th>
                                        <th>Booking Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if (!empty($passengerDetails)) : ?>
                                        <?php foreach ($passengerDetails as $passenger) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($passenger['guest_id']) ?></td>
                                                <td><?= htmlspecialchars($passenger['title']) ?></td>
                                                <td><?= htmlspecialchars($passenger['last_name'] . ', ' . $passenger['first_name']) ?></td>
                                                <td><?= htmlspecialchars($passenger['date_of_birth']) ?></td>
                                                <td><?= htmlspecialchars($passenger['contact_number']) ?></td>
                                                <td><?= htmlspecialchars($passenger['nationality']) ?></td>
                                                <td><?= htmlspecialchars($passenger['email']) ?></td>
                                                <td><?= htmlspecialchars($passenger['booking_date']) ?></td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewPassenger<?= $passenger['guest_id'] ?>">
                                                            <i class="bi bi-eye"></i> View
                                                        </button>
                                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPassenger<?= $passenger['guest_id'] ?>">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </button>
                                                        <form method="post" onsubmit="return confirm('Are you sure you want to delete this passenger?');">
                                                            <input type="hidden" name="passenger_id" value="<?= $passenger['guest_id'] ?>">
                                                            <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
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