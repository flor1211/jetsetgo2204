<?php
    session_start();

      // Redirect to login if not logged in
      if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
          header("Location: ../login.php");
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

    <title>JetSetGo - Airplanes</title>

    <link rel="stylesheet" href="admin-style.css">

  </head>
  <body style="margin: 0;">

        <!-- Sidebar Container -->
        <div id="sidebar-container">
            <script>
                fetch("sidebar.php")
                  .then(res => res.text())
                  .then(data => {
                    document.getElementById("sidebar-container").innerHTML = data;
                  });
              </script>
        </div>

        <?php include '../modals.php'; ?>


        <!-- Main Content -->
        <div style="margin-left: 225px; padding: 20px;">
            <h1>Airplanes</h1>
                <section class="p-3">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h2 class="m-0">Plane Details</h2>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planeForm">
                                <i class="bi bi-airplane-engines"></i> New Plane
                            </button>
                        </div>
                    </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped table-hover mt-3 text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Plane ID</th>
                                    <th>No. of Seats</th>
                                    <th>Status</th>
                                    <th>Total Flights</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="data">
                                <tr>
                                    <td>1</td>
                                    <td>JSG013</td>
                                    <td>150</td>
                                    <td><span class="badge bg-success text-white rounded-pill">Available</span></td>
                                    <td>6</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i> View</button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editData"><i class="bi bi-pencil-square"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>JSG014</td>
                                    <td>150</td>
                                    <td><span class="badge bg-warning text-white rounded-pill">In Maintenance</span></td>
                                    <td>25</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i> View</button>
                                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>JSG015</td>
                                    <td>160</td>
                                    <td><span class="badge bg-success text-white rounded-pill">Available</span></td>
                                    <td>12</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i> View</button>
                                        <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </div>


    <!--MODALS-->
        <!-- Add Data Modal-->
                <div class="modal fade" id="planeForm">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Plane</h4>
                            </div>
                            
                            <div class="modal-body">
                                <form action="#" id="addPlaneForm">
                                    <div class="card imgHolder">
                                        <label for="imgInput" class="upload" id="uploadLabel">
                                            <input type="file" name="" id="imgInput"> 
                                            <i class="bi bi-file-earmark-arrow-up"></i>
                                            Upload Photo
                                        </label>
                                        <img src="./assets/images/planeupload.png" alt="" width="auto" height="auto" class="img">
                                    </div>
                            
                                    <div class="inputField">
                                        <div>
                                            <label for="name">Plane ID</label>
                                            <input type="text" name="" id="planeID">
                                        </div>
                                        <div>
                                            <label for="name">No. of Seats</label>
                                            <input type="number" name="" id="numseats">
                                        </div>
                                        <div>
                                            <label for="name">Status</label>
                                            <input type="text" name="" id="status">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            

                            <div class="modal-footer">
                                <button type="submit" form="addPlaneForm" class="btn btn-primary submit">Add</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- Read Data Modal-->
                <div class="modal fade" id="readData">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modla-title">Plane</h4>
                            </div>
                            
                            <div class="modal-body">
                                <form action="#" id="readPlaneForm">
                                    <div class="card imgHolder">
                                        <img src="./assets/images/planeupload.png" alt="" width="auto" height="auto">
                                    </div>

                                    <div class="inputField">
                                        <div>
                                            <label for="name">Plane ID</label>
                                            <input type="text" name="" id="name" disabled>
                                        </div>
                                        <div>
                                            <label for="name">No. of Seats</label>
                                            <input type="number" name="" id="numseats" disabled>
                                        </div>
                                        <div>
                                            <label for="name">Status</label>
                                            <input type="text" name="" id="status" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                            </div>

                        </div>
                    </div>
                </div>
        <!-- Edit Data Modal-->
                <div class="modal fade" id="editData">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Plane</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editPlaneForm">
                                    <div class="card imgHolder">
                                        <label for="editImgInput" class="upload">
                                            <input type="file" id="editImgInput"> 
                                            <i class="bi bi-file-earmark-arrow-up"></i>
                                        </label>
                                        <img id="editImgPreview" src="./assets/images/planeupload.png" alt="Plane Image" width="auto" height="auto">
                                    </div>

                                    <div class="inputField">
                                        <div>
                                            <label for="editPlaneID">Plane ID</label>
                                            <input type="text" id="editPlaneID">
                                        </div>
                                        <div>
                                            <label for="editNumSeats">No. of Seats</label>
                                            <input type="number" id="editNumSeats">
                                        </div>
                                        <div>
                                            <label for="editStatus">Status</label>
                                            <input type="text" id="editStatus">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="editPlaneForm" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="admin.js"></script>

  </body>
</html>