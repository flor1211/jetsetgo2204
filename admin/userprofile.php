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

    <?php include 'includes/sidebar.php'; ?>

    <section class="home-section">

        <?php include 'includes/navbar.php'; ?>

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

    </section>

<!-- --------------------------------------------- --> 

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- JAVASCRIPT --> 
    <script src="admin-js.js"></script>



</body>
</html>