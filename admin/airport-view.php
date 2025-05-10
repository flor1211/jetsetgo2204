<?php
session_start();

require_once '../database/admin-crud.php';

$crud = new Crud();



if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['airport_id'])) {
    $airport_id = $_POST['airport_id'];
    $_SESSION['airport_id'] = $airport_id; 
} else {
    $airport_id = $_SESSION['airport_id'] ?? null;
}


$matchingAirport = null;
$flights = $crud->getFlightsWithBookedSeats();

if ($airport_id !== null) {
    try {
        
        $airports = $crud->getAllAirportsFromView();

        
        foreach ($airports as $a) {
            if ($a['airport_id'] == $airport_id) {
                $matchingAirport = $a;
                break;
            }
        }

        if (!$matchingAirport) {
            echo "No airport found with ID: " . htmlspecialchars($airport_id);
        }

        
        $allFlights = $crud->getFlightsByCodeView(); 
        $filteredFlights = [];

        if ($matchingAirport) {
            $airportCode = $matchingAirport['airport_code'];

            foreach ($allFlights as $flight) {
                if ($flight['departure_code'] == $airportCode || $flight['arrival_code'] == $airportCode) {
                    $filteredFlights[] = $flight;
                }
            }
        }
    } catch (Exception $e) {
        echo "Error loading airport: " . $e->getMessage();

    }
} else {
    echo "No airport ID specified.";
}


// Step 3: Check session login (good practice to keep)

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}




// Step 4: Show login success banner if needed

$showSuccess = false;
$username = $_SESSION["username"];

if (isset($_SESSION["login_success"])) {

    $showSuccess = true;

    unset($_SESSION["login_success"]);
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
                <li class="breadcrumb-item"><a href="airports.php">Airport</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Airport #<?= htmlspecialchars($airport_id) ?>
                </li>
            </ol>
        </nav>


        <!-- Left Box: Flight Details -->
        <div class="card-body">
            <div class="d-flex flex-row gap-3">

                <!-- Airport Code Box -->
                <div class="card shadow mb-4" style="width: 200px;">
                    <div class="card-body">
                        <label>AIRPORT CODE</label>
                        <input type="text" class="form-control" value="<?= $matchingAirport['airport_code'] ?>" disabled>
                    </div>
                </div>

                <!-- Airport Name Box -->
                <div class="card shadow mb-4" style="width: 500px;">
                    <div class="card-body">
                        <label>AIRPORT NAME</label>
                        <input type="text" class="form-control" value="<?= $matchingAirport['airport_name'] ?>" disabled>
                    </div>
                </div>

                <!-- Location Box -->
                <div class="card shadow mb-4" style="width: 400px;">
                    <div class="card-body">
                        <label>LOCATION</label>
                        <input type="text" class="form-control" value="<?= $matchingAirport['airport_location'] ?>" disabled>
                    </div>
                </div>
            </div>
        </div>


        <!-- Passengers Title Section -->


        <table class="table table-bordered" style="width: 95%; max-width: 1400px; margin: auto;">

            <thead>

                <tr>
                    <th colspan="9" class="bg-light text-start" style="font-size: 1.3rem; padding: 1rem;">
                        Flights in <?= htmlspecialchars($matchingAirport['airport_location']) ?> International Airport
                    </th>
                </tr>
                <tr>
                    <th>Flight ID</th>
                    <th>Date</th>
                    <th>Departure - Arrival</th>
                    <th>Plane Code</th>
                    <th>Number of Seats</th>
                    <th>Available Seats</th>
                    <th>Booked Seats</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($filteredFlights)): ?>
                    <?php foreach ($filteredFlights as $flight): ?>
                        <tr>
                            <td><?= htmlspecialchars($flight['flight_id']) ?></td>
                            <td><?= htmlspecialchars($flight['date']) ?></td>
                            <td><?= htmlspecialchars($flight['departure_code']) . ' - ' . htmlspecialchars($flight['arrival_code']) ?></td>
                            <td><?= htmlspecialchars($flight['plane_code'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($flight['numofseats']) ?></td>
                            <td>
                                <?php
                                $bookedSeats = 0;
                                foreach ($flights as $f) {
                                    if ($f['flight_id'] == $flight['flight_id']) {
                                        $bookedSeats = $f['booked_seats'];
                                        break;
                                    }
                                }

                                $availableSeats = max(0, (int)$flight['numofseats'] - (int)$bookedSeats);
                                echo htmlspecialchars($availableSeats);
                                ?>
                            </td>
                            <td>
                                <?php
                                // Find the flight in the $flights array by ID
                                $bookedSeats = 0;
                                foreach ($flights as $f) {
                                    if ($f['flight_id'] == $flight['flight_id']) {
                                        $bookedSeats = $f['booked_seats'];
                                        break;
                                    }
                                }
                                echo htmlspecialchars($bookedSeats);
                                ?>
                            </td>

                            <td>
                                <span class="badge bg-<?= $flight['onSale'] == 1 ? 'success' : 'secondary' ?>">
                                    <?= $flight['onSale'] == 1 ? 'On Sale' : 'Not On Sale' ?>
                                </span>

                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#viewPlane<?= $flight['flight_id'] ?>">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editPlane<?= $flight['flight_id'] ?>">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <form method="post" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this plane?');">
                                    <input type="hidden" name="plane_id" value="<?= $flight['flight_id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No flights found for this airport.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </section>
</body>