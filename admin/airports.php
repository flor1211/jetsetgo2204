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

    <title>JetSetGo - Airports</title>

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
            <h1>Airports</h1>
                  <section class="p-3">
                      <div class="row">
                          <div class="col-12 d-flex justify-content-between align-items-center">
                              <h2 class="m-0">Airport Details</h2>
                              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#airportForm">
                                  <i class="bi bi-airplane-engines"></i> New Airport
                              </button>
                          </div>
                      </div>

                  <div class="row">
                      <div class="col-12">
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
                                  <tr>
                                      <td>1</td>
                                      <td>MNL</td>
                                      <td>Ninoy Aquino International Airport</td>
                                      <td>Metro Manila</td>
                                      <td>
                                          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i> View</button>
                                          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editData"><i class="bi bi-pencil-square"></i> Edit</button>
                                          <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                      </td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>CLK</td>
                                    <td>Clark Internation Airpoty</td>
                                    <td>New Clark City, Tarlac</td>
                                      <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i> View</button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editData"><i class="bi bi-pencil-square"></i> Edit</button>
                                          <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                      </td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>CEB</td>
                                    <td>Mactan-Cebu International Airport</td>
                                    <td>Cebu City</td>
                                      <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i> View</button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editData"><i class="bi bi-pencil-square"></i> Edit</button>
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
        <!-- Add Airport Modal-->
        <div class="modal fade" id="airportForm">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Airport</h4>
                    </div>
                    
                    <div class="modal-body">
                        <form action="#" id="AirportForm">
                            <div class="inputField">
                                <div>
                                    <label for="name">Code</label>
                                    <input type="text" name="" id="airportcode">
                                </div>
                                <div>
                                    <label for="name">Airport Name</label>
                                    <input type="text" name="" id="airportname">
                                </div>
                                <div>
                                    <label for="name">Location</label>
                                    <input type="text" name="" id="airportlocation">
                                </div>

                            </div>
                        </form>
                    </div>
                    

                    <div class="modal-footer">
                        <button type="submit" form="addAirportForm" class="btn btn-primary submit">Add</button>
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
                        <h4 class="modal-title">View Airport Details</h4>
                    </div>
                    
                    <div class="modal-body">
                        <form action="#" id="readAirportForm">
                            <div class="inputField">
                                <div>
                                    <label for="name">Code</label>
                                    <input type="text" name="" id="airportcode" disabled>
                                </div>
                                <div>
                                    <label for="name">Airport Name</label>
                                    <input type="text" name="" id="airportname" disabled>
                                </div>
                                <div>
                                    <label for="name">Location</label>
                                    <input type="text" name="" id="airportlocation" disabled>
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
                        <h4 class="modal-title">Edit Airport Details</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="AirportForm">
                            <div class="inputField">
                                <div>
                                    <label for="name">Code</label>
                                    <input type="text" name="" id="airportcode" disabled>
                                </div>
                                <div>
                                    <label for="name">Airport Name</label>
                                    <input type="text" name="" id="airportname" disabled>
                                </div>
                                <div>
                                    <label for="name">Location</label>
                                    <input type="text" name="" id="airportlocation" disabled>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="editAirportForm" class="btn btn-primary">Save Changes</button>
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