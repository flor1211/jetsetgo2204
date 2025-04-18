<?php
    session_start();

    require_once '../database/admin-crud.php';

    $user = new Crud();
    $editingUser = null;

    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        $allAirports = $user->searchAirport($search);
    } else {
        $allAirports = $user->getAllAirports();
    }

    // AJAX request: FOR AUTOMATIC SEARCH
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            if (empty($allAirports)) {
                echo '<tr><td colspan="5" class="text-center text-muted">- No Data Available –</td></tr>';
            } else {
                foreach ($allAirports as $u): ?>
                    <tr>
                        <td><?= $u['airport_id'] ?></td>
                        <td><?= htmlspecialchars($u['airport_code']) ?></td>
                        <td><?= htmlspecialchars($u['airport_name']) ?></td>
                        <td><?= htmlspecialchars($u['airport_location']) ?></td>
                        <td>
                            <!-- View -->
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData<?= $u['airport_id'] ?>"><i class="bi bi-eye"></i> View</button>

                            <!-- Edit -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editData<?= $u['airport_id'] ?>"><i class="bi bi-pencil-square"></i> Edit</button>

                            <!-- Delete -->
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this airport?');">
                                <input type="hidden" name="airportid" value="<?= $u['airport_id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;
            }
            exit;
        }

      // Redirect to login if not logged in
      if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
          header("Location: ../login.php");
          exit;
      }

      if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['add'])) {
            $user->addAirport($_POST['airportcode'], $_POST['airportname'], $_POST['airportlocation']);
            header("Location: airports.php?success=1");
            exit;
        }

        if(isset($_POST['update'])) {
            $user->updateAirport($_POST['airportid'], $_POST['airportcode'], $_POST['airportname'], $_POST['airportlocation']);
            header("Location: airports.php?updated=1");
            exit;
        }


        if(isset($_POST['delete'])) {

            $user->deleteAirport($_POST['airportid']);
            header("Location: airports.php?deleted=1");
            exit;

        }
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

        <script src="admin.js"></script>

        <title>JetSetGo | Airports</title>

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
            <h2>Airports</h2>

            <section class="p-3">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h3 class="m-0">Airport Details</h3>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#airportForm">
                                <i class="bi bi-airplane-engines"></i> New Airport
                            </button>
                    </div>
                </div>

                <!-- SEARCH BAR -->
                <br>
                <div class="mb-3 d-flex">
                    <input type="text" id="airportsearchInput" class="form-control me-2" placeholder="Search by Code/Name/Location">
                </div>

                <!-- TABLE --> 
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mt-3 text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Airport Name</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>   
                            <tbody id="data">
                                <?php foreach ($allAirports as $u): ?>
                                    <tr>
                                        <td><?= $u['airport_id'] ?></td>
                                        <td><?= htmlspecialchars($u['airport_code']) ?></td>
                                        <td><?= htmlspecialchars($u['airport_name']) ?></td>
                                        <td><?= htmlspecialchars($u['airport_location']) ?></td>
                                        <td>
                                        <!-- VIEW -->
                                          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData<?= $u['airport_id']?>"><i class="bi bi-eye"></i> View</button>
                                        <!-- EDIT -->  
                                          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editData<?= $u['airport_id']?>" ><i class="bi bi-pencil-square"></i> Edit</button>
                                          
                                        <!-- Delete -->
                                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this airport?');">
                                                <input type="hidden" name="airportid" value="<?= $u['airport_id'] ?>">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- MODALS -->
                                        <!-- View Data Modal-->
                                        <div class="modal fade" id="readData<?= $u['airport_id']?>">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">View Airport Details</h4>
                                                    </div>
                                                    

   
                                                    <form action="#" id="readAirportForm">
                                                        <div class="modal-body">
                                                            <div class="row g-3" style="padding:30px;">
                                                                <input type="hidden" name="" id="airportid" value="<?= htmlspecialchars($u['airport_id']) ?>">
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-5 col-form-label" for="name">Airport Code</label>
                                                                    <input class="form-control" type="text" name="" id="airportcode" value="<?= htmlspecialchars($u['airport_code']) ?>" disabled >
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-5 col-form-label" for="name">Airport Name</label>
                                                                    <input class="form-control" type="text" name="" id="airportname" value="<?= htmlspecialchars($u['airport_name']) ?>" disabled>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-2 col-form-label" for="name">Location</label>
                                                                    <input class="form-control" type="text" name="" id="airportlocation" value="<?= htmlspecialchars($u['airport_location']) ?>" disabled>
                                                                </div>
                                                        </div>
                                                     </form>

                                                     <br>
                                                <h3 class="modal-title">Flights in <?= htmlspecialchars($u['airport_name']) ?> </h3>
                                                <hr>

                                                MAY TABLE DITO, NANDITO YUNG MGA DEPARTING / ARRIVING FLIGHTS SA <?= htmlspecialchars($u['airport_name']) ?>

                                                </div>
                                                
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Data Modal-->
                                        <div class="modal fade" id="editData<?= $u['airport_id']?>">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Airport Details</h4>
                                                        </div>
                            


                                                        <form action="#" id="editAirportForm<?= $u['airport_id'] ?>" method="POST">
                                                            <div class="modal-body">
                                                                <div class="row g-3" style="padding:30px;">
                                                                        <input type="hidden" name="airportid" id="airportid" value="<?= ($u['airport_id']) ?>">
                                                                    <div class="mb-3 row">
                                                                        <label class="col-sm-5 col-form-label" for="name">Airport Code</label>
                                                                        <input class="form-control" type="text" name="airportcode" id="airportcode<?= ($u['airport_id']) ?>" value="<?= htmlspecialchars($u['airport_code']) ?>" placeholder="Ex. MNL, CLK, CEB">                                                                </div>
                                                                    <div class="mb-3 row">
                                                                        <label class="col-sm-5 col-form-label" for="name">Airport Name</label>
                                                                        <input class="form-control" type="text" name="airportname" id="airportname<?= ($u['airport_id']) ?>" value="<?= htmlspecialchars($u['airport_name']) ?>">
                                                                    </div>
                                                                    <div class="mb-3 row">
                                                                        <label class="col-sm-2 col-form-label" for="name">Location</label>
                                                                        <input class="form-control"  type="text" name="airportlocation" id="airportlocation<?= ($u['airport_id']) ?>" value="<?= htmlspecialchars($u['airport_location']) ?>">
                                                                    </div>

                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" name="update" form="editAirportForm<?= $u['airport_id'] ?>" class="btn btn-primary">Save Changes</button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </form>

            
                                                    </div>
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
    <!-- Add Airport Modal-->
        <div class="modal fade" id="airportForm">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">New Airport</h4>
                    </div>

                    <form action="#" id="addAirportForm" method = "POST">
                        <div class="modal-body">

                            <div class="row g-3" style="padding:30px;">
                                <div class="mb-3 row">
                                    <label class="col-sm-5 col-form-label" for="name">Airport Code</label>
                                    <input class="form-control" type="text" name="airportcode" id="airportcode" placeholder="Ex. MNL, CLK, CEB">
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-5 col-form-label" for="name">Airport Name</label>
                                    <input class="form-control" type="text" name="airportname" id="airportname">
                                </div>
                                <div  class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="name">Location</label>
                                    <input class="form-control" type="text" name="airportlocation" id="airportlocation">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" name= "add" form="addAirportForm" class="btn btn-primary submit">Add</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                    


                </div>
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
                        text: 'Airport added successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif (isset($_GET['updated'])): ?>
                    Swal.fire({
                        icon: 'info',
                        title: 'Updated',
                        text: 'Airport updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                });
                <?php elseif (isset($_GET['deleted'])): ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Deleted',
                        text: 'Airport deleted successfully!',
                        timer: 2000,
                        showConfirmButton: false
                });
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

    <!-- Script for AJAX search--> 
    <script>
            document.getElementById('airportsearchInput').addEventListener('input', function () {
                const searchValue = this.value;

                fetch('airports.php?search=' + encodeURIComponent(searchValue), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('data').innerHTML = data;
                });
            });
    </script>

    

</body>
</html>

