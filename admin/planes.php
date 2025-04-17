<?php
    session_start();
    require_once '../database/admin-crud.php';

    
      // Redirect to login if not logged in
      if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("Location: ../login.php");
        exit;
    }

    $user = new Crud();
    $editingUser = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['add'])) {
            // Handle file upload
            if (isset($_FILES['plane_photo']) && $_FILES['plane_photo']['error'] == 0) {
                $fileTmp = $_FILES['plane_photo']['tmp_name'];
                $fileName = basename($_FILES['plane_photo']['name']);
                $targetDir = "PlaneUploads/";
                $targetFile = $targetDir . $fileName;

                // Create the directory if it doesn't exist
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (move_uploaded_file($fileTmp, $targetFile)) {
                    $user->AddPlane($_POST['plane_code'], $_POST['seats'], $_POST['status'], $targetFile);
                    header("Location: planes.php?success=1");
                    exit;
                } else {
                    echo "Failed to upload image.";
                }
            } else {
                echo "No image uploaded or upload error.";
            }

        }
        
        if (isset($_POST['update'])) {
                $photoPath = null;

                //Check if a new file is uploaded
                if (isset($_FILES['plane_photo']) && $_FILES['plane_photo']['error'] == 0) {
                    $fileTmp = $_FILES['plane_photo']['tmp_name'];
                    $fileName = basename($_FILES['plane_photo']['name']);
                    $targetDir = "PlaneUploads/";
                    $targetFile = $targetDir . $fileName;

                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }

                    if (move_uploaded_file($fileTmp, $targetFile)) {
                        $photoPath = $targetFile;
                    } else {
                        echo "Image upload failed.";
                        return;
                    }
                } else {
                    //Retain the current image if no new image is uploaded
                    $photoPath = $_POST['current_photo'];
                }

                $user->updatePlane(
                    $_POST['plane_id'],
                    $_POST['plane_code'],
                    $_POST['seats'],
                    $_POST['status'],
                    $photoPath
                );

                header("Location: planes.php?updated=1");
                exit;
            }

            if (isset($_POST['delete'])) {
                if (isset($_POST['plane_id']) && !empty($_POST['plane_id'])) {
                    $user->deletePlane($_POST['plane_id']);
                    header("Location: planes.php?deleted=1");
                    exit;
                } else {
                    echo "Error: Plane ID is missing.";
                }
            }
        }



    $planes = $user->getAllPlanes();
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

        <title>JetSetGo | Planes</title>

    </head>
<body>
    <?php include 'includes/sidebar.php'; ?>
        
    <section class="home-section">
        
        <?php include 'includes/navbar.php'; ?>

        <div style="margin-left: 10px; padding: 20px;">
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

                <!-- TABLE -->
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
                                <?php foreach ($planes as $plane): ?>
                                    <tr>
                                        <td><?= $plane['plane_id'] ?></td>
                                        <td><?= $plane['plane_code'] ?></td>
                                        <td><?= $plane['plane_numseats'] ?></td>
                                        <td>

                                            <?php
                                            $status = $plane['plane_status'];
                                            $badgeClass = 'bg-secondary'; // default

                                            if ($status === 'Available') {
                                                $badgeClass = 'bg-success';
                                            } elseif ($status === 'Under Maintenance') {
                                                $badgeClass = 'bg-warning';
                                            } elseif ($status === 'Unavailable') {
                                                $badgeClass = 'bg-danger';
                                            }
                                            ?>
                                            <span class="badge <?= $badgeClass ?> text-white rounded-pill">
                                                <?= $status ?>
                                            </span>

                                        </td>
                                        <td><?= $plane['plane_totalflights'] ?></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#viewPlane<?= $plane['plane_id'] ?>">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPlane<?= $plane['plane_id'] ?>">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <form method="post" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this plane?');">
                                                <input type="hidden" name="plane_id" value="<?= $plane['plane_id'] ?>">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                <!-- MODALS -->
                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewPlane<?= $plane['plane_id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">View Plane Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="readPlaneForm">
                                                        
                                                        <div class="row">
                                                            <!-- Left side: image -->
                                                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                                <div class="card imgHolder" style="width: 100%; max-width: 300px;">
                                                                    <img id="editImgPreview<?= $plane['plane_id']; ?>" src="<?= htmlspecialchars($plane['plane_photo']) ?>" alt="Plane Image" class="img-fluid">

                                                                </div>
                                                            </div>

                                                            <!-- Right side: fields -->
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="planenum" class="form-label">Plane Number</label>
                                                                    <input type="text" id="planenum" class="form-control"
                                                                        value="<?= htmlspecialchars($plane['plane_code']) ?>" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="numseats" class="form-label">No. of Seats</label>
                                                                    <input type="number" id="numseats" class="form-control"
                                                                        value="<?= htmlspecialchars($plane['plane_numseats']) ?>" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <input type="text" id="plane_status" class="form-control"
                                                                        value="<?= htmlspecialchars($plane['plane_status']) ?>" disabled>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </form>

                                                    <br>
                                                    <h3 class="modal-title">Flights of <?= htmlspecialchars($plane['plane_code']) ?> </h3>
                                                    <hr>

                                                    MAY TABLE DITO, NANDITO YUNG MGA FLIGHTS NI <?= htmlspecialchars($plane['plane_code']) ?>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Back</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editPlane<?= $plane['plane_id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Plane</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editPlaneForm<?= $plane['plane_id']; ?>" method="POST" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <!-- Left: Image upload & preview -->
                                                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                                <div class="card imgHolder" style="width: 100%; max-width: 300px;">
                                                                    <label for="editImgInput<?= $plane['plane_id']; ?>" class="upload d-flex flex-column align-items-center justify-content-center p-3" style="cursor: pointer;">
                                                                        <i class="bi bi-file-earmark-arrow-up fs-2 mb-2"></i>
                                                                        <span>Upload Photo</span>
                                                                        <input type="file" name="plane_photo" id="editImgInput<?= $plane['plane_id']; ?>" hidden>
                                                                        <input type="hidden" name="current_photo" value="<?= htmlspecialchars($plane['plane_photo']) ?>">
                                                                    </label>
                                                                    <img id="editImgPreview<?= $plane['plane_id']; ?>" src="<?= htmlspecialchars($plane['plane_photo']) ?>" alt="Plane Image" class="img-fluid">
                                                                </div>
                                                            </div>

                                                            <!-- Right: Input fields -->
                                                            <div class="col-md-6">
                                                                <input type="hidden" name="plane_id" value="<?= htmlspecialchars($plane['plane_id']); ?>">

                                                                <div class="mb-3">
                                                                    <label for="editPlaneNum<?= $plane['plane_id']; ?>" class="form-label">Plane Number</label>
                                                                    <input type="text" name="plane_code" id="editPlaneNum<?= $plane['plane_id']; ?>" class="form-control"
                                                                        value="<?= htmlspecialchars($plane['plane_code']); ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="editNumSeats<?= $plane['plane_id']; ?>" class="form-label">No. of Seats</label>
                                                                    <input type="number" name="seats" id="editNumSeats<?= $plane['plane_id']; ?>" class="form-control"
                                                                        value="<?= htmlspecialchars($plane['plane_numseats']); ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="editStatus<?= $plane['plane_id']; ?>" class="form-label">Status</label>
                                                                    <select name="status" id="editStatus<?= $plane['plane_id']; ?>" class="form-select" required>
                                                                        <option value="Available" <?= $plane['plane_status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                                                                        <option value="Under Maintenance" <?= $plane['plane_status'] == 'Under Maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
                                                                        <option value="Unavailable" <?= $plane['plane_status'] == 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
                                                                    </select>
                                                                </div>


                                                                <input type="hidden" name="update" value="1">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        form="editPlaneForm<?= $plane['plane_id']; ?>"
                                                        class="btn btn-primary">Save Changes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
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
 
    <!-- MODAL FOR ADDING -->
    <div class="modal fade" id="planeForm">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Plane</h4>
                </div>
                <div class="modal-body">
                    <form action="planes.php" method="post" id="addPlaneForm" enctype="multipart/form-data">
                        <div class="card imgHolder">
                            <label for="imgInput" class="upload" id="uploadLabel">
                                <input type="file" name="plane_photo" id="imgInput" required>
                                <i class="bi bi-file-earmark-arrow-up"></i> Upload Photo
                            </label>
                            <img src="./assets/images/planeupload.png" alt="" class="img" width="auto" height="auto">
                        </div>
                        <div class="inputField">
                            <div>
                                <label for="planeID">Plane ID</label>
                                <input type="text" name="plane_code" id="planeID" required>
                            </div>
                            <div>
                                <label for="numseats">No. of Seats</label>
                                <input type="number" name="seats" id="numseats" required>
                            </div>
                            <div>
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="" disabled selected>Select status</option>
                                    <option value="Available">Available</option>
                                    <option value="Under Maintenance">Under Maintenance</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="addPlaneForm" name="add" class="btn btn-primary submit">Add</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
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
                        text: 'Plane added successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                <?php elseif (isset($_GET['updated'])): ?>
                    Swal.fire({
                        icon: 'info',
                        title: 'Updated',
                        text: 'Plane updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                });
                <?php elseif (isset($_GET['deleted'])): ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Deleted',
                        text: 'Plane deleted successfully!',
                        timer: 2000,
                        showConfirmButton: false
                });
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

</body>
</html>
