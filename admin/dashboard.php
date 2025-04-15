<?php
session_start();

require_once '../database/admin-crud.php';

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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstap S icons CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- SweetAlert2 CDN-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="admin.js"></script>

    <title>JetSetGo</title>

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
        


        <!-- Main Content -->
        <div style="margin-left: 225px; padding: 20px;">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        </div>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!-- SweetAlert message -->
    <?php if ($showSuccess): ?>
        <script>
            Swal.fire({
              title: "Login success!",
              icon: "success",
              confirmButtonColor: "#3085d6"
            });
        </script>
    <?php endif; ?>        
    
    
    



  </body>
</html>