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

    $allFlights = $user->getAllFlights();
    $allAirports = $user->getAllAirports();
    $allAvailablePlanes = $user->getAllAvailablePlanes();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if (isset($_POST['add'])) {

        $saleStatus = isset($_POST['new_on_Sale']) ? 1 : 0;

        $DEPairportInfo = $user->searchAirport($_POST['new_dep_loc']);
        $ARRairportInfo = $user->searchAirport($_POST['new_arr_loc']);
        $planeInfo = $bookingUser->searchPlane($_POST['new_planeCode']);

        

        // echo "<h3>Departure Airport Info:</h3><pre>";
        // var_dump($DEPairportInfo);
        // echo "</pre>";

        // echo "<h3>Arrival Airport Info:</h3><pre>";
        // var_dump($ARRairportInfo);
        // echo "</pre>";

        // echo "<h3>Plane Info:</h3><pre>";
        // print_r($_POST['new_planeCode']);
        // var_dump($planeInfo);
        // echo "</pre>";

        $depFlight = $DEPairportInfo[0];
        $arrFlight = $ARRairportInfo[0];
        $plane = $planeInfo[0];

        $user->addFlight($depFlight['airport_code'], $depFlight['airport_name'], $depFlight['airport_location'], $_POST['new_dep_time'], $arrFlight['airport_code'], $arrFlight['airport_name'], $arrFlight['airport_location'], $_POST['new_arr_time'], $_POST['new_date'], $_POST['new_planeCode'], $plane['plane_photo'], $_POST['new_num_seats'], $_POST['new_price'], $saleStatus);
        header("Location: flights.php?success=1");
        exit; 

      }
      if (isset($_POST['update'])) {

        $flightID = $_POST['flightId'];
        $saleStatus = isset($_POST['on_Sale']) ? 1 : 0;

        $DEPairportInfo = $user->searchAirport($_POST['dep_loc']);
        $ARRairportInfo = $user->searchAirport($_POST['arr_loc']);
        $planeInfo = $bookingUser->searchPlane($_POST['edit_planeCode']);

        $depFlight = $DEPairportInfo[0];
        $arrFlight = $ARRairportInfo[0];
        $plane = $planeInfo[0];


        $user->updateFlight($flightID, $depFlight['airport_code'], $depFlight['airport_name'], $depFlight['airport_location'], $_POST['dep_time'], $arrFlight['airport_code'], $arrFlight['airport_name'], $arrFlight['airport_location'], $_POST['arr_time'], $_POST['date'], $_POST['edit_planeCode'], $plane['plane_photo'], $_POST['edit_num_seats'], $_POST['price'], $saleStatus);
        header("Location: flights.php?success=1");
        exit;
        
      }

      if (isset($_POST['delete'])) {

 
        $user->deleteFlight($_POST['deleteflightId']);
        header("Location: flights.php?success=1");
        exit;
      }

      
    }

    // AJAX for synchronous updates

    if (isset($_POST['plane_code'])) {
        $planeCode = $_POST['plane_code'];
        $seats = $user->getPlaneDetails($planeCode);

        if ($seats) {
            echo json_encode([
                'plane_numseats' => $seats[0]['plane_numseats'] ?? '0',
                'plane_photo' => $seats[0]['plane_photo'] ?? '0'
            ]);
        } else {
            echo json_encode([
                'plane_numseats' => '0',
                'plane_photo' => '0'
            ]);
        }
        exit;
    }
    


?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Bootstap S icons CDN-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- SWEET -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- AJAX -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="admin.js"></script>

        <title>JetSetGo</title>

        <link rel="stylesheet" href="admin.css">

        <script>
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                alert("Error: " + msg + " in " + url + " at line " + lineNo);
                return false;
            };
        </script>
        
        
    </head>
<body>

    <?php include 'includes/sidebar.php'; ?>

    <section class="home-section">

        <?php include 'includes/navbar.php'; ?>

        <div style="margin-left: 10px; padding: 20px;">
            <h2>Flights</h2>

            <section class="p-3">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h3 class="m-0">Flight Details</h3>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewFlight">
                                <i class="bi bi-airplane-engines"></i> New Flight
                            </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mt-3 text-center table-bordered">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>DATE</th>
                            <th>LOCATION</th>
                            <th>PLANE CODE</th>
                            <th>SEATS</th>
                            <th>AVAILABLE</th>
                            <th>BOOKED</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                            </tr>
                        </thead> 

                        <tbody id="data">
                            <?php foreach ($allFlights as $u): ?>
                                <tr>
                                    <td><?= $u['flight_id'] ?></td>
                                    <td><?= htmlspecialchars($u['date']) ?></td>
                                    <td><?= htmlspecialchars($u['departure_code'])?> - <?= htmlspecialchars($u['arrival_code']) ?></td>
                                    <td><?= htmlspecialchars($u['plane_code']) ?></td>
                                    <td><?= htmlspecialchars($u['numofseats']) ?></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td><?= $u['onSale'] ? 'On Sale' : 'Not on Sale' ?></td>
                                    <td>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewFlight<?= $u['flight_id']?>"><i class="bi bi-eye"> View </i></button>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editFlight<?= $u['flight_id']?>"><i class="bi bi-pencil-square"> Edit </i></button>
                                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this flight?');">
                                        <input type="hidden" name="deleteflightId" value="<?= $u['flight_id'] ?>">
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                    </form>
                                    </td>
                                </tr>
                                <!-- MODALS -->
                                    <!-- MODAL FOR VIEWING -->
                                    <div class="modal fade" id="viewFlight<?= $u['flight_id']?>">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title" id="viewFlight">View Flight</h4>
                                        </div>

                                            <form action="#" id="viewFlightsForm" method = "POST">
                                            <div class="modal-body">
                                                <h4 class="modal-title">Flight Details</h4>
                                                <hr>
                                                <div class="container">
                                                    <div class="row mb-3">
                                                    <div class="col-md-6">

                                                        <label for="departureLocation">DEPARTURE LOCATION</label>
                                                        <input type="text" class="form-control" id="dep_loc" name="" value="<?= htmlspecialchars($u['departure_code']) ?> - <?= htmlspecialchars($u['departure_location']) ?>" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="arrivalLocation">ARRIVAL LOCATION</label>
                                                        <input type="text" class="form-control" id="arr_loc" name="" value="<?= htmlspecialchars($u['arrival_code']) ?> - <?= htmlspecialchars($u['arrival_location']) ?>" disabled>
                                                    </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="departureTime">DEPARTURE TIME</label>
                                                        <input type="time" class="form-control" id="dep_time" name="" value="<?= htmlspecialchars($u['departure_time']) ?>" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="arrivalTime">ARRIVAL TIME</label>
                                                        <input type="time" class="form-control" id="arr_time" name="" value="<?= htmlspecialchars($u['arrival_time']) ?>" disabled>
                                                    </div>
                                                    </div>
                                                
                                                    <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="date">DATE</label>
                                                        <input type="date" class="form-control" id="date" name="" value="<?= htmlspecialchars($u['date']) ?>" disabled>
                                                    </div>
                                                    </div>
                                                    
                                                    <h4 class="modal-title">Plane Details</h4>
                                                
                                                    <hr>

                                                <div class="d-flex gap-4">
                                                    <div class="w-100">
                                                        <div class="mb-3">
                                                        <label for="planeNumber">PLANE CODE</label>
                                                        <input class="form-control" id="view_planeCode" name="" value="<?= htmlspecialchars($u['plane_code']) ?>" disabled>
                                                        </div>

                                                        <div class="mb-3">
                                                        <label for="view_num_seats">NUMBER OF SEATS</label>
                                                        <input type="text" class="form-control" id="view_num_seats" name="" value="<?= htmlspecialchars($u['numofseats']) ?>" disabled>
                                                        </div>

                                                        <div class="mb-3">
                                                        <label for="price">PRICE</label>
                                                        <input type="text" class="form-control" id="price" placeholder="₱ 0.00" name="" value="<?= htmlspecialchars($u['price']) ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <img 
                                                        src="https://images6.alphacoders.com/408/408258.jpg" 
                                                        alt="Plane Image" 
                                                        class="img-fluid rounded shadow view_plane_image" 
                                                        style="width: 250px; height: 170px; margin-top: 30px;">
                                                    </div>
                                                </div>
                                                <br>
                                                    <h3 class="modal-title">Passengers of <?= htmlspecialchars($u['departure_location']) ?> - <?= htmlspecialchars($u['arrival_location']) ?>  </h3>
                                                <hr>
                                                    MAY TABLE DITO, NANDITO YUNG LIST NG PASSENGERS NA NAGBOOK NG Flight  <?= htmlspecialchars($u['departure_location']) ?> - <?= htmlspecialchars($u['arrival_location']) ?>
                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                                    </div>
                                                
                                                </div>


                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- MODAL FOR EDITING FLIGHT -->
                                    <div class="modal fade" id="editFlight<?= $u['flight_id']?>">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editFlight">Edit Flight</h4>
                                            </div>

                                                <form action="#" id="editFlightsForm<?= $u['flight_id']?>" method="POST">
                                                <div class="modal-body">
                                                    <h4 class="modal-title">Edit Flight Details</h4>
                                                    <hr>
                                                    <div class="container">
                                                        <div class="row mb-3">
                                                        <input type="hidden" name="flightId" value="<?= $u['flight_id'] ?>">

                                                        <div class="col-md-6">

                                                            <label for="departureLocation">DEPARTURE LOCATION</label>
                                                            <select class="form-control" id="dep_loc" name="dep_loc" required>
                                                                <option value="<?= htmlspecialchars($u['departure_code']) ?>" selected disabled hidden><?= htmlspecialchars($u['departure_code']) ?> - <?= htmlspecialchars($u['departure_location']) ?> </option>
                                                                <?php foreach ($allAirports as $r): ?>
                                                                    <option value="<?= $r['airport_code']?>"><?= $r['airport_code']?> - <?= $r['airport_location']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="arrivalLocation">ARRIVAL LOCATION</label>
                                                            <select class="form-control" id="arr_loc" name="arr_loc" required>
                                                                <option value="<?= htmlspecialchars($u['arrival_location']) ?>" selected disabled hidden><?= htmlspecialchars($u['arrival_code']) ?> - <?= htmlspecialchars($u['arrival_location']) ?></option>
                                                                <?php foreach ($allAirports as $r): ?>
                                                                    <option value="<?= $r['airport_code']?>"><?= $r['airport_code']?> - <?= $r['airport_location']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="departureTime">DEPARTURE TIME</label>
                                                            <input type="time" class="form-control" id="dep_time" name="dep_time" value="<?= htmlspecialchars($u['departure_time']) ?>" >
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="arrivalTime">ARRIVAL TIME</label>
                                                            <input type="time" class="form-control" id="arr_time" name="arr_time" value="<?= htmlspecialchars($u['arrival_time']) ?>" >
                                                        </div>
                                                        </div>
                                                    
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="date">DATE</label>
                                                                <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($u['date']) ?>">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label d-block">STATUS</label>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" role="switch" id="on_Sale<?= $u['flight_id']?>" name="on_Sale" 
                                                                                <?= $u['onSale'] ? 'checked' : '' ?> onchange="updateSaleLabel(this)">
                                                                        <label id="saleLabel<?= $u['flight_id']?>" class="form-check-label <?= $u['onSale'] ? 'text-success' : 'text-danger' ?>" for="on_Sale<?= $u['flight_id']?>">
                                                                            <?= $u['onSale'] ? '* On Sale' : '* Not on Sale' ?>
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <h4 class="modal-title">Plane Details</h4>
                                                    
                                                        <hr>

                                                    <div class="d-flex gap-4">
                                                        <div class="w-100">
                                                            <div class="mb-3">
                                                                <label for="edit_planeCode">PLANE CODE</label>
                                                                
                                                                <select class="form-control" id="edit_planeCode" name="edit_planeCode"  required> 
                                                                    <option value="<?= htmlspecialchars($u['plane_code']) ?>" selected hidden><?= htmlspecialchars($u['plane_code']) ?></option>
                                                                    <?php foreach ($allAvailablePlanes as $p): ?>
                                                                        <option value="<?= $p['plane_code']?>"><?= $p['plane_code']?></option>
                                                                    <?php endforeach; ?>

                                                                    <!-- </?php foreach ($allAvailablePlanes as $p): ?>
                                                                        <option value="</?= $p['plane_code']?>" </?= $u['plane_code'] === $p['plane_code'] ? 'selected' : '' ?>>
                                                                            </?= $p['plane_code']?>
                                                                        </option>
                                                                    </?php endforeach; ?> -->

                                                                </select>

                                                                

                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="edit_num_seats">NUMBER OF SEATS</label>
                                                                <input type="text" class="form-control" id="edit_num_seats" name="edit_num_seats" value="<?= htmlspecialchars($u['numofseats']) ?>" readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="price">PRICE</label>
                                                                <input type="text" class="form-control" id="price" placeholder="₱ 0.00" name="price" value="<?= htmlspecialchars($u['price']) ?>">
                                                            </div>
                                                        </div>

                                                        <div class="flex-shrink-0">
                                                            <img 
                                                            src="https://images6.alphacoders.com/408/408258.jpg" 
                                                            alt="Plane Image" 
                                                            class="img-fluid rounded shadow edit_plane_image" 
                                                            style="width: 250px; height: 170px; margin-top: 30px;">
                                                        </div>
                                                    </div>

                                                    </div>
                                                    </div>
                                                
                                                        <div class="modal-footer">
                                                            <button type="submit" name="update" form="editFlightsForm<?= $u['flight_id']?>" class="btn btn-primary submit">Save</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                                        </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </section>

<!-- --------------------------------------------- --> 

    <!-- MODAL FOR ADDING -->
    <div class="modal fade" id="addNewFlight" tabindex="-1" aria-labelledby="addNewFlight" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title" id="addNewFlight">Add New Flight</h4>

            </div>

            <form action="#" id="addFlightsForm" method = "POST">
            <div class="modal-body">
              <h4 class="modal-title">Flight Details</h4>
              <hr>
                <div class="container">
                  <div class="row mb-3">
                    <div class="col-md-6">

                        <label for="departureLocation">DEPARTURE LOCATION</label>
                        <select class="form-control" id="new_dep_loc" name="new_dep_loc" required>
                            <option value="" selected disabled hidden>-- Select Departure Location --</option>
                            <?php foreach ($allAirports as $u): ?>
                                <option value="<?= $u['airport_code']?>"><?= $u['airport_code']?> - <?= $u['airport_location']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="arrivalLocation">ARRIVAL LOCATION</label>
                        <select class="form-control" id="new_arr_loc" name="new_arr_loc" required>
                            <option value="" selected disabled hidden>-- Select Arrival Location --</option>
                            <?php foreach ($allAirports as $u): ?>
                                <option value="<?= $u['airport_code']?>"><?= $u['airport_code']?> - <?= $u['airport_location']?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="text" class="form-control" id="new_arr_code" name="new_arr_code" hidden>
                        <input type="text" class="form-control" id="new_arr_name" name="new_arr_name" hidden>

                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="departureTime">DEPARTURE TIME</label>
                      <input type="time" class="form-control" id="new_dep_time" name="new_dep_time" required>
                    </div>
                    <div class="col-md-6">
                      <label for="arrivalTime">ARRIVAL TIME</label>
                      <input type="time" class="form-control" id="new_arr_time" name="new_arr_time" required>
                    </div>
                  </div>
               
                  <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date">DATE</label>
                      <input type="date" class="form-control" id="new_date" name="new_date" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">STATUS</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="new_on_Sale" name="new_on_Sale" onchange="updateNewSaleLabel(this)">
                                    <label id="new_saleLabel" class="form-check-label" for="new_on_Sale">* Not on Sale
                                </label>
                            </div>

                    </div>
                  </div>
                  
                  <h4 class="modal-title">Plane Details</h4>
                
                  <hr>

                <div class="d-flex gap-4">
                    <div class="w-100">
                        <div class="mb-3">
                        <label for="planeNumber">PLANE CODE</label>
                        <select class="form-control" id="new_planeCode" name="new_planeCode" required>
                            <option value="" selected disabled hidden>-- Select Plane --</option>
                            <?php foreach ($allAvailablePlanes as $u): ?>
                                <option value="<?= $u['plane_code']?>"><?= $u['plane_code']?></option>
                            <?php endforeach; ?>
                        </select>

                        </div>

                        <div class="mb-3">
                        <label for="seatsAvailable">NUMBER OF SEATS</label>
                            <input type="text" class="form-control" id="new_num_seats" name="new_num_seats" value="" readonly>
                        </div>


                        <div class="mb-3">
                        <label for="price">PRICE</label>
                        <input type="text" class="form-control" id="new_price" placeholder="₱ 0.00" name="new_price" required>
                        </div>
                        
                    </div>

                    <div class="flex-shrink-0">
                        <img src="PlaneUploads/No_Image_Available.jpg" alt="new_plane_image" class="img-fluid rounded shadow new_plane_image" style="width: 250px; height: 170px; margin-top: 30px;">
                    </div>
                </div>

                </div>
              </div>
            
                    <div class="modal-footer">
                        <button type="submit" name="add" form="addFlightsForm" class="btn btn-primary submit">ADD</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>

                    </div>
                  </div>
          </form>
          </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- JAVASCRIPT --> 
    <script src="admin-js.js"></script>

    <!-- SweetAlert -->
    <?php if (isset($_GET['success']) || isset($_GET['updated']) || isset($_GET['deleted'])): ?>
        <script>
                document.addEventListener('DOMContentLoaded', function () {
                <?php if (isset($_GET['success'])): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Flight added successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif (isset($_GET['updated'])): ?>
                    Swal.fire({
                        icon: 'info',
                        title: 'Updated',
                        text: 'Flight updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                });
                <?php elseif (isset($_GET['deleted'])): ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Deleted',
                        text: 'Flight deleted successfully!',
                        timer: 2000,
                        showConfirmButton: false
                });
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>


    <script>
        $(document).ready(function () {
            $('#new_planeCode').change(function () {
                var planeCode = $(this).val();

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: { plane_code: planeCode },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#new_num_seats').val(data.plane_numseats);

                        if (data.plane_photo !== '0') {
                            $('.new_plane_image').attr('src',data.plane_photo).show();
                        } else {
                            $('.new_plane_image').hide();
                        }
                    }
                }); 
            });
        });

        $(document).ready(function () {
            $('#edit_planeCode').change(function () {
                var planecode = $(this).val();

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: { plane_code: planecode },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#edit_num_seats').val(data.plane_numseats);

                        if (data.plane_photo !== '0') {
                            $('.edit_plane_image').attr('src',data.plane_photo).show();
                        } else {
                            $('.edit_plane_image').hide();
                        }
                    }
                }); 
            });
        });

        $(document).ready(function () {
            $('#view_planeCode').change(function () {
                var planecode = $(this).val();

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: { plane_code: planecode },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#view_num_seats').val(data.plane_numseats);

                        if (data.plane_photo !== '0') {
                            $('.view_plane_image').attr('src',data.plane_photo).show();
                        } else {
                            $('.view_plane_image').hide();
                        }
                    }
                }); 
            });
        });
    </script>

    <script>
        function updateSaleLabel(checkbox) {
            const flightId = checkbox.id.replace('on_Sale', '');
            const label = document.getElementById('saleLabel' + flightId);

            if (checkbox.checked) {
            label.textContent = '* On Sale';
            label.classList.remove('text-danger');
            label.classList.add('text-success');
            } else {
            label.textContent = '* Not On Sale';
            label.classList.remove('text-success');
            label.classList.add('text-danger');
            }
        }

        function updateNewSaleLabel(checkbox) {
            const flightId = checkbox.id.replace('new_on_Sale', '');
            const label = document.getElementById('new_saleLabel' + flightId);

            if (checkbox.checked) {
            label.textContent = '* On Sale';
            label.classList.remove('text-danger');
            label.classList.add('text-success');
            } else {
            label.textContent = '* Not On Sale';
            label.classList.remove('text-success');
            label.classList.add('text-danger');
            }
        }
    </script>



</body>
</html>