<?php
session_start();

require_once '../database/admin-crud.php';

$crud = new Crud();
$airport_id = $_SESSION['airport_id'] ?? null;



if ($airports) {
    $airports = $crud->getAllAirports($airport_id);
    // $airport = null;
}

if ($airport_id !== null) {
    foreach ($airports as $a) {
        if ($a['airport_id'] == $airportId) {
            $matchingAirport = $a;
            break;
        }
    }
} else {
    echo "No airport ID specified.";
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
                <li class="breadcrumb-item active" aria-current="page">Airport #001</li>
            </ol>
        </nav>

                <!-- Left Box: Flight Details -->
                <div class="card-body">
                    <div class="d-flex flex-row gap-3">

                        <!-- Airport Code Box -->
                        <div class="card shadow mb-4" style="width: 200px;">
                            <div class="card-body">
                                <label>AIRPORT CODE</label>
                                    <input type="text" class="form-control" value="<?= $airports['airport_code'] ?>" disabled>
                            </div>
                        </div>

                        <!-- Airport Name Box -->
                        <div class="card shadow mb-4" style="width: 500px;">
                            <div class="card-body">
                                <label>AIRPORT NAME</label>
                                    <input type="text" class="form-control" value="<?= $airports['airport_name'] ?>" disabled>
                            </div>
                        </div>

                        <!-- Location Box -->
                        <div class="card shadow mb-4" style="width: 400px;">
                            <div class="card-body">
                                <label>LOCATION</label>
                                <input type="text" class="form-control" value="<?= $airports['airport_location'] ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>


            <!-- Passengers Title Section -->

            <div class="row justify-content-start">
                <div class="col-md-6 ms-3"> <!-- Adjust width here (e.g., col-md-6, col-md-7, etc.) -->
                    <div class="card shadow mb-2">
                        <div class="card-body">
                        <h4 class="mb-0" style="font-size: 1.3rem;">
                            Flights in <?= $airports['airport_location'] . ' International Airport' ?>
                        </h4>

                        </div>
                    </div>
                </div>
            </div>




            <!-- Full-width Flight Schedule Table -->
            <div class="container mt-4 ms-1">
                <div class="card shadow">
                    <div class="card-body">   
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Plane Code</th>
                                        <th>Seats</th>
                                        <th>Available</th>
                                        <th>Booked</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>1</td>
                                        <td>2025-05-08</td>
                                        <td>Manila - Cebu</td>
                                        <td>PC-001</td>
                                        <td>180</td>
                                        <td>120</td>
                                        <td>60</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#viewPlane1">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPlane1">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <form method="post" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this plane?');">
                                                <input type="hidden" name="plane_id" value="1">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>2025-05-09</td>
                                        <td>Cebu - Davao</td>
                                        <td>PC-002</td>
                                        <td>150</td>
                                        <td>80</td>
                                        <td>70</td>
                                        <td><span class="badge bg-secondary">Inactive</span></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#viewPlane1">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPlane1">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <form method="post" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this plane?');">
                                                <input type="hidden" name="plane_id" value="1">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div> <!-- END of .container -->


    </section>
</body>