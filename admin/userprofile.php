<?php
    session_start();

    require_once '../database/admin-crud.php';

      // Redirect to login if not logged in
      if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
          header("Location: ../login.php");
          exit;
      }

    $user = new Crud();
    $accountID = $_SESSION['accountID'];

    $accountInfo = $user->getAccountDetails($accountID);

    $accountPhoto = null;

    if ($accountInfo[0]['account_photo'] == null){
        $accountPhoto = "assets/noprofilepic.png";
    } else {
        $accountPhoto = $accountInfo[0]['account_photo'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['savePhoto'])) {
            if (isset($_FILES['uploadPicture']) && $_FILES['uploadPicture']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'AccountUploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
    
                $fileName = basename($_FILES['uploadPicture']['name']);
                $targetPath = $uploadDir . $fileName;
    
                $allowedTypes = ['image/jpeg', 'image/png'];
                $fileType = mime_content_type($_FILES['uploadPicture']['tmp_name']);
    
                // echo "<pre>";
                // echo "FILES:\n";
                // print_r($_FILES);
                // echo "POST:\n";
                // print_r($_POST);
                // echo "</pre>";
    
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['uploadPicture']['tmp_name'], $targetPath)) {
                        $user->updateAccountPhoto($accountID, $targetPath);
                        header("Location: ".$_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        echo "Failed to move file.";
                    }
                } else {
                    echo "Invalid file type.";
                }
            }
        }
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
<<<<<<< HEAD
        
        <style>
            .upload-placeholder {
            width: 120px;
            height: 120px;
            background-color: #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            }


        </style>
=======
 <style>
    .user-profile-container {
  display: flex;
  background: #ffffff;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
  width: 700px;
  margin: 0 auto;
  gap: 30px;
  align-items: center;
}

.profile-form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 16px;
}

.profile-form .form-group {
  display: flex;
  flex-direction: column;
}

.profile-form label {
  font-weight: bold;
  margin-bottom: 4px;
}

.profile-form input[type="text"],
.profile-form input[type="password"] {
  width: 250px;
  padding: 8px 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #f1f1f1;
}

.profile-upload {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.profile-upload .upload-placeholder {
  width: 120px;
  height: 120px;
  background-color: #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
}

.profile-upload button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 6px 20px;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
}

    </style>
>>>>>>> 7aabd57d22e6fd27a6826aaac967b13a84f472e4
        <!-- for debugging  -->
        <script>
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                alert("Error: " + msg + " in " + url + " at line " + lineNo);
                return false;
            };
        </script>

        <title>JetSetGo | User Profile</title>

    </head>
<body>

<<<<<<< HEAD
    <!-- </?php include 'includes/sidebar.php'; ?> -->
=======
    <?php include 'includes/sidebar.php'; ?>
>>>>>>> 7aabd57d22e6fd27a6826aaac967b13a84f472e4

    <section class="home-section">

        <?php include 'includes/navbar.php'; ?>

<<<<<<< HEAD
        <div class="container mt-4" style="padding:10px; margin-left: 20px">
            <h2>User Profile</h2>

            <div class="row mt-4" >

                <div class="col-md-3 d-flex flex-column align-items-center justify-content-start">

                    <!-- VIEW MODE -->
                    <div id="viewMode" class="text-center">
                        <img id="profilePhotoView" src="<?= $accountPhoto ?>" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <button class="btn btn-secondary btn-sm" onclick="toggleEdit(true)">
                                <i class="bi bi-pencil"></i> Change Photo
                            </button>
                        </div>
                    </div>
                    
                    <!-- EDIT MODE -->
                    <form id="editMode" method="POST" action="" enctype="multipart/form-data" class="text-center d-none">
                        <img id="profilePhotoEdit" src="<?= $accountPhoto ?>" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                        
                        <input type="file" id="uploadPicture" name="uploadPicture" accept="image/jpeg, image/png" onchange="previewImage(event)" style="display: none;">
                        
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <button class="btn btn-primary btn-sm" type="button" onclick="document.getElementById('uploadPicture').click();">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                            <button class="btn btn-danger btn-sm" type="button" onclick="removePhoto()">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                            <button class="btn btn-secondary btn-sm" type="button" onclick="toggleEdit(false)">
                                Cancel
                            </button>
                            <button class="btn btn-success btn-sm" name="savePhoto" type="submit">
                                <i class="bi bi-save"></i> Save
                            </button>
                        </div>
                    </form>


                </div>


                <div class="col-md-8" style="padding-top: 20px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input style="background-color: white" type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($accountInfo[0]['account_fullname']) ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <input style="background-color: white" type="text" class="form-control" id="role" name="role" value="<?= htmlspecialchars($accountInfo[0]['account_role']) ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input style="background-color: white" type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($accountInfo[0]['account_username']) ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input style="background-color: white" type="password" class="form-control" id="password" name="password" value="<?= htmlspecialchars($accountInfo[0]['account_password']) ?>" disabled>
                        </div>
                    </div>
                </div>

            </div>

        </div>

=======
        <div style="margin-left: 10px; padding: 20px;">
            <h2>User Profile</h2>
        </div>

        <div class="user-profile-container">
  <div class="profile-form">
    <div class="form-group">
      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname">
    </div>
    <div class="form-group">
      <label for="role">Role</label>
      <input type="text" id="role" name="role">
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password">
    </div>
  </div>

  <div class="profile-upload">
    <div class="upload-placeholder"></div>
    <button type="button">UPLOAD</button>
  </div>
</div>

>>>>>>> 7aabd57d22e6fd27a6826aaac967b13a84f472e4
    </section>

<!-- --------------------------------------------- --> 

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<<<<<<< HEAD

    <script>
        function toggleEdit(editing) {
            document.getElementById('viewMode').classList.toggle('d-none', editing);
            document.getElementById('editMode').classList.toggle('d-none', !editing);
        }

        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];

            if (!file) return;

            const allowedTypes = ['image/jpeg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File',
                    text: 'Only JPG and PNG images are allowed.'
                });
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('profilePhotoEdit').src = reader.result;
            };
            reader.readAsDataURL(file);
        }

        function removePhoto() {
            document.getElementById('profilePhotoEdit').src = "assets/noprofilepic.png";
            document.getElementById('uploadPicture').value = "";
        }
    </script>


=======
    <!-- JAVASCRIPT --> 
    <script src="admin-js.js"></script>
>>>>>>> 7aabd57d22e6fd27a6826aaac967b13a84f472e4



</body>
</html>