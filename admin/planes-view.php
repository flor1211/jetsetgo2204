<?php
session_start();
require_once '../database/admin-crud.php';

// Redirect to login if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}

$user = new Crud();

// Image upload handling
$uploadMessage = '';
$uploadedImage = 'default-plane.jpg'; // Default image

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['plane_image'])) {
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["plane_image"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["plane_image"]["tmp_name"], $targetFile)) {
        $uploadMessage = "Image uploaded successfully.";
        $uploadedImage = $fileName;
    } else {
        $uploadMessage = "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JetSetGo | Planes</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<?php include 'includes/sidebar.php'; ?>

<section class="home-section">
    <?php include 'includes/navbar.php'; ?>

    <div style="margin-left: 10px; padding: 20px;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Planes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Planes #001</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Left Panel -->
            <div class="col-md-8">
                <div class="row mb-3">
                    <!-- Plane Number & Seats -->
                    <div class="col-md-5">
                        <label class="form-label">Plane Number</label>
                        <input type="text" class="form-control form-control-sm mb-2" value="JSG123" disabled>

                        <label class="form-label">No. of Seats</label>
                        <input type="text" class="form-control form-control-sm" value="100" disabled>
                    </div>

                    <!-- Status (closer to Plane Number) -->
                    <div class="col-md-3 d-flex flex-column justify-content-start ms-2">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control form-control-sm" value="Unavailable" disabled>
                    </div>
                </div>

                <!-- Flights section title -->
                <div class="mt-3">
                    <h6>Flights of JSG123</h6>
                </div>

                <!-- Placeholder for flight table -->
                <div class="mt-2" style="min-height: 150px; border: 1px dashed #ccc; border-radius: 8px; padding: 20px;">
                    <p class="text-muted">[Flight table will be displayed here]</p>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="col-md-4 text-center">
                <h5>Upload Plane Image</h5>

                <?php if ($uploadMessage): ?>
                    <div class="alert alert-info"><?= $uploadMessage ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <input class="form-control mb-2" type="file" name="plane_image" required>
                    <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                </form>

                <div class="mt-3">
                    <img src="../uploads/<?= htmlspecialchars($uploadedImage) ?>" class="img-fluid rounded" alt="Plane Image" style="max-height: 200px;">
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
