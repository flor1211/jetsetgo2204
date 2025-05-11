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

    $crud = new Crud();
    $counts = $crud->getDashboardCounts(); 


    $totalFlights = $counts['total_flights'];
    $totalBookings = $counts['total_bookings'];
    $totalPlanes = $counts['total_planes'];
    $totalRevenue = $counts['total_revenue'];

    $recentBooking = $crud->getRecentBookings();

    $dates = $flights = $planes = [];

    foreach ($recentBooking as $booking) {
        $dates[] = $booking['flight_date'];
        $flights[] = $booking['route'];
        $planes[] = $booking['plane_code'];
    }
    

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

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="admin.css">

    <!-- for debugging  -->
    <script>
        window.onerror = function(msg, url, lineNo, columnNo, error) {
            alert("Error: " + msg + " in " + url + " at line " + lineNo);
            return false;
        };
    </script>

    <style>

    </style>

    <title>JetSetGo | Dashboard</title>

</head>

<body>

    <?php include 'includes/sidebar.php'; ?>

    <section class="home-section">

        <?php include 'includes/navbar.php'; ?>
        <!-- Title Header Content -->
        <div style="margin-left: 10px; padding-left: 20px; padding-right: 20px; padding-top: 30px; display: flex; align-items:center; justify-content: center">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        </div>

        <!-- Home Content -->
        <div class="home-content">

            <div class="overview-boxes">
                <!-- boxes  -->
                <div class="box">
                    <div class="left-side" style="padding-right: 10px;">
                        <div class="box-topic">Bookings</div>
                        <div class="number"><?php echo $totalBookings; ?></div>
                        <div class="indicator">
                            <i class="bi bi-arrow-up"></i>
                            <span class="text">Up from yesterday</span>
                        </div>
                    </div>
                    <i class="bi bi-journal-bookmark summary" id="totalbookingIcon"></i>
                </div>

                <div class="box">
                    <div class="left-side" style="padding-right: 10px;">
                        <div class="box-topic">Total Flights</div>
                        <div class="number"><?php echo $totalFlights; ?></div>
                        <div class="indicator">
                            <i class="bi bi-arrow-up"></i>
                            <span class="text">Up from yesterday</span>
                        </div>
                    </div>
                    <i class="bi bi-airplane-engines summary two" id="totalflightsIcon"></i>
                </div>

                <div class="box">
                    <div class="left-side" style="padding-right: 10px;">
                        <div class="box-topic">Revenue</div>
                        <div class="number">$<?php echo $totalRevenue ?></div>
                        <div class="indicator">
                            <i class="bi bi-arrow-up"></i>
                            <span class="text">Up from yesterday</span>
                        </div>
                    </div>
                    <i class="bi bi-cash-coin summary three" id=revenueIcon></i> <!-- id for the revenue Icon -->
                </div>

                <div class="box">
                    <div class="left-side" style="padding-right: 10px;">
                        <div class="box-topic">Planes</div>
                        <div class="number"><?php echo $totalPlanes; ?></div>
                        <div class="indicator">
                            <i class="bi bi-arrow-up"></i>
                            <span class="text">Up from yesterday</span>
                        </div>
                    </div>
                    <i class="bi bi-airplane summary" id="totalplanesIcon"></i>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const bookingIcon = document.getElementById("totalbookingIcon");
                    const totalflightsIcon = document.getElementById("totalflightsIcon");
                    const totalplanesIcon = document.getElementById("totalplanesIcon");
                    const revenueIcon = document.getElementById("revenueIcon");

                    [bookingIcon, totalflightsIcon, revenueIcon, totalplanesIcon].forEach(icon => {
                        icon.style.cursor = "pointer";


                        icon.addEventListener("mouseover", function() {
                            icon.style.color = "#708090";
                        });

                        icon.addEventListener("mouseout", function() {
                            icon.style.color = ""; 
                        });
                    });

                    bookingIcon.addEventListener("click", function() {
                        window.location.href = "bookings.php";
                    });

                    totalflightsIcon.addEventListener("click", function() {
                        window.location.href = "flights.php";
                    });

                    totalplanesIcon.addEventListener("click", function() {
                        window.location.href = "planes.php";
                    });

                    revenueIcon.addEventListener("click", function() {
                        window.location.href = "planes.php";
                    });
                });
            </script>

            <!-- TABLE SUMMARY -->
            <div class="summary-boxes">
                <!-- LEFT BOX -->
                <div class="recent-booking box" style=>
                    <div class="title">Recent Booking</div>
                    <div class="booking-details">
                        <ul class="details" style="padding-left:0px;">
                            <li class="topic">Date</li>
                            <?php foreach ($dates as $date): ?>
                                <li><a href="#"><?php echo htmlspecialchars($date); ?></a></li>
                            <?php endforeach; ?>

                        </ul>
                        <ul class="details" style="padding-left:0px;">
                            <li class="topic">Flight</li>
                            <?php foreach ($flights as $flight): ?>
                                <li><a href="#"><?php echo htmlspecialchars($flight); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <ul class="details">
                            <li class="topic">Plane</li>
                            <?php foreach ($planes as $plane): ?>
                                <li><a href="#"><?php echo htmlspecialchars($plane); ?></a></li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                    <div class="button">
                        <a href="bookings.php">See All</a>

                    </div>
                </div>
                <!-- RIGHT BOX -->
                <!-- <div class="recent-flight box">
                    <div class="title">Flight Status</div>
                    <ul style="padding-left:0px;">
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
                        </li>
                        <li>
                            <a href="">
                                <img src="" alt="">
                                <span class="flight-name">MNL - CEB</span>
                            </a>
                            <span class="status">On board</span>
                        </li>

                    </ul>
                </div> -->
                                <!-- FIRST BOX -->
                <div class="recent-booking box" >
                    <div class="title">Mode of Payment</div>
                    <?php   

                        $mopChart = $crud->getModeofPaymentCount();

                        $labels = [];
                        $counts = [];

                        foreach ($mopChart as $row) {
                            $labels[] = $row['payment_type'];
                            $counts[] = $row['count'];
                        }
                    ?>

                    <div style="width: 300px; height: 300px; margin: auto; padding-top: 10px;">
                        <canvas id="paymentChart"></canvas>
                    </div>

                    <script>
                        const paymentChartLabels = <?php echo json_encode($labels); ?>;
                        const paymentChartData = <?php echo json_encode($counts); ?>;

                        const ctx = document.getElementById('paymentChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: paymentChartLabels,
                                datasets: [{
                                    data: paymentChartData,
                                    backgroundColor: [
                                        '#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d',
                                        '#17a2b8', '#fd7e14', '#6610f2', '#20c997', '#e83e8c',
                                        '#343a40', '#adb5bd', '#198754', '#0dcaf0', '#f8f9fa'
                                    ]

                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    </script>

                </div>
            </div>

            <!-- GRAPH SUMMARY -->
            <div class="summary-boxes">
                


                <!-- SECOND BOX -->
                <div class="recent-flight box">
                    <div class="title">Payment Status</div>

                        <?php   

                        $mopChart = $crud->getPaymentStatusCount();

                        $labels = [];
                        $counts = [];

                        foreach ($mopChart as $row) {
                            $labels[] = $row['payment_status'];
                            $counts[] = $row['status'];
                        }
                    ?>

                    <div style="width: 300px; height: 300px; margin: auto; padding-top: 10px;">
                        <canvas id="lineChart"></canvas>
                    </div>

                    <script>
                        const statuspaymentChartLabels = <?php echo json_encode($labels); ?>;
                        const statuspaymentChartData = <?php echo json_encode($counts); ?>;

                        const sctx = document.getElementById('lineChart').getContext('2d');
                        new Chart(sctx, {
                            type: 'pie',
                            data: {
                                labels: statuspaymentChartLabels,
                                datasets: [{
                                    data: paymentChartData,
                                    backgroundColor: [
                                        '#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d',
                                        '#17a2b8', '#fd7e14', '#6610f2', '#20c997', '#e83e8c',
                                        '#343a40', '#adb5bd', '#198754', '#0dcaf0', '#f8f9fa'
                                    ]

                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    </script>

                    

                </div>
                <div class="recent-booking box" >
                    <div class="title">Nationality</div>    

                    <?php   
                        $nationalityChart = $crud->getNationalityCount();

                        $labels = [];
                        $counts = [];

                        foreach ($nationalityChart as $row) {
                            $labels[] = $row['nationality'];
                            $counts[] = $row['count'];
                        }
                    ?>

                    <div style="width: 400px; height: 400px; margin: auto; padding-top: 10px;">
                        <canvas id="nationalityChart"></canvas>
                    </div>

                    <script>
                        const nationalityChartLabels = <?php echo json_encode($labels); ?>;
                        const nationalityChartData = <?php echo json_encode($counts); ?>;

                        const nctx = document.getElementById('nationalityChart').getContext('2d');
                        new Chart(nctx, {
                            type: 'pie',
                            data: {
                                labels: nationalityChartLabels,
                                datasets: [{
                                    data: nationalityChartData,
                                    backgroundColor: [
                                        '#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d',
                                        '#17a2b8', '#fd7e14', '#6610f2', '#20c997', '#e83e8c',
                                        '#343a40', '#adb5bd', '#198754', '#0dcaf0', '#f8f9fa'
                                    ]
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        position: 'right' // ✅ Move legend to the right
                                    }
                                }
                            }
                        });
                    </script>



                </div>
                


            </div>

            <div class="summary-boxes">
                <!-- THIRD BOX -->

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