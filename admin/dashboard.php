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

        <title>JetSetGo | Dashboard</title>

    </head>
<body>

    <?php include 'includes/sidebar.php'; ?>

    <section class="home-section">

        <?php include 'includes/navbar.php'; ?>
        <!-- Title Header Content -->
        <div style="margin-left: 10px; padding-left: 20px; padding-right: 20px; padding-top: 30px; display: flex; align-items:center; justify-content: center">
            <h2 >Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        </div>

        <!-- Home Content -->
        <div class="home-content">

            <div class="overview-boxes">
                <!-- boxes  -->
                <div class="box">
                    <div class="left-side">
                    <div class="box-topic">Bookings</div>
                    <div class="number">48</div>
                    <div class="indicator">
                        <i class="bi bi-arrow-up"></i>
                        <span class="text">Up from yesterday</span>
                    </div>
                    </div>
                    <i class="bi bi-journal-bookmark summary"></i>
                </div>

                <div class="box">
                    <div class="left-side">
                    <div class="box-topic">Total Flights</div>
                    <div class="number">15</div>
                    <div class="indicator">
                        <i class="bi bi-arrow-up"></i>
                        <span class="text">Up from yesterday</span>
                    </div>
                    </div>
                    <i class="bi bi-airplane-engines summary two"></i>
                </div>

                <div class="box">
                    <div class="left-side">
                    <div class="box-topic">Revenue</div>
                    <div class="number">$15, 485</div>
                    <div class="indicator">
                        <i class="bi bi-arrow-up"></i>
                        <span class="text">Up from yesterday</span>
                    </div>
                    </div>
                    <i class="bi bi-cash-coin summary three"></i>
                </div>

                <div class="box">
                    <div class="left-side">
                    <div class="box-topic">Planes</div>
                    <div class="number">8</div>
                    <div class="indicator">
                        <i class="bi bi-arrow-up"></i>
                        <span class="text">Up from yesterday</span>
                    </div>
                    </div>
                    <i class="bi bi-airplane summary"></i>
                </div>
            </div>

            <!-- TABLE SUMMARY -->
            <div class="summary-boxes">
                <!-- LEFT BOX -->
                <div class="recent-booking box">
                    <div class="title">Recent Booking</div>
                    <div class="booking-details">
                    <ul class="details">
                        <li class="topic">Date</li>
                        <li><a href="#">02 Jan 2025</a></li>
                        <li><a href="#">02 Jan 2025</a></li>
                        <li><a href="#">02 Jan 2025</a></li>
                        <li><a href="#">02 Jan 2025</a></li>
                        <li><a href="#">02 Jan 2025</a></li>
                        <li><a href="#">02 Jan 2025</a></li>
                    </ul>
                    <ul class="details">
                        <li class="topic">Flight</li>
                        <li><a href="#">MNL - CLK</a></li>
                        <li><a href="#">CEB - MNL</a></li>
                        <li><a href="#">DAV - CEB</a></li>
                        <li><a href="#">CLK - DAV</a></li>
                        <li><a href="#">CEB - DAV</a></li>
                        <li><a href="#">MNL - DAV</a></li>
                    </ul>
                    <ul class="details">
                        <li class="topic">Plane</li>
                        <li><a href="#">JSG 125</a></li>
                        <li><a href="#">JSG 128</a></li>
                        <li><a href="#">JSG 126</a></li>
                        <li><a href="#">JSG 127</a></li>
                        <li><a href="#">JSG 120</a></li>
                        <li><a href="#">JSG 124</a></li>
                    </ul>
                    </div>
                    <div class="button">
                        <a href="bookings.php">See All</a>

                    </div>
                </div>
                <!-- RIGHT BOX --> 
                <div class="recent-flight box">
                    <div class="title">Flight Status</div>
                    <ul>
                        <li>
                            <a href="">
                                <img src="" alt="">
                                <span class="flight-name">MNL - CEB</span>
                            </a>
                            <span class="status">On board</span>
                        </li>
                        <li>
                            <a href="">
                                <img src="" alt="">
                                <span class="flight-name">MNL - CEB</span>
                            </a>
                            <span class="status">On board</span>
                        </li>
                        <li>
                            <a href="">
                                <img src="" alt="">
                                <span class="flight-name">MNL - CEB</span>
                            </a>
                            <span class="status">On board</span>
                        </li>
                        <li>
                            <a href="">
                                <img src="" alt="">
                                <span class="flight-name">MNL - CEB</span>
                            </a>
                            <span class="status">On board</span>
                        </li>                <li>
                            <a href="">
                                <img src="" alt="">
                                <span class="flight-name">MNL - CEB</span>
                            </a>
                            <span class="status">On board</span>
                        </li>

                    </ul>
                </div>
                
            
            </div>

        </div>

    </section>

<!-- --------------------------------------------- --> 


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- JAVASCRIPT --> 
    <script src="admin-js.js"></script>

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