<?php
    session_start();

    require_once '../database/admin-crud.php';

    $user = new Crud();
    $editingUser = null;

    $searchCard = $_GET['cardsearchInput'] ?? '';
    $searchOnsite = $_GET['cardsearchInput'] ?? '';

    // $limit = (int)($_GET['paymentViewLimit'] ?? 5);

    $page = max(1, (int)($_GET['page'] ?? 1));
    $limit =20;
    $offset = ($page - 1) * $limit;

    $totalCardPayment = $user->countCardPayments($searchCard);
    $totalCardPages = ceil($totalCardPayment / $limit);



    $totalOnsitePayment = $user->countOnsitePayments($searchOnsite);
    $totalOnsitePages = ceil($totalOnsitePayment / $limit);

    if (!empty($searchCard)) {
        $allCardPayments = $user->searchCardPaymentswithLimit($searchCard, $limit, $offset);
    } else {

        $allCardPayments = $user->searchCardPaymentswithLimit($searchCard, $limit, $offset);
    }

    echo "<pre>";
    print_r($allCardPayments);
    echo "</pre>";
    
    if (!empty($searchOnsite)) {
        $allOnsitePayments = $user->searchOnsitePaymentswithLimit($searchOnsite, $limit, $offset);
    } else {

        $allOnsitePayments = $user->searchOnsitePaymentswithLimit($searchOnsite, $limit, $offset);
    }

    echo "<pre>";
    print_r($allOnsitePayments);
    echo "</pre>";
    

      // Redirect to login if not logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
          header("Location: ../login.php");
          exit;
    }

        // SweetAlert
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

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

    <!-- </?php include 'includes/sidebar.php'; ?> -->
        
    <section class="home-section">
        
        <!-- </?php include 'includes/navbar.php'; ?> -->

        <div style="margin-left: 10px; padding: 20px;">
            <h2>Airport Management</h2>

            <section class="p-3">

                <!-- SEARCH BAR -->
                <br>
                <div class="mb-3 d-flex">
                    <input type="text" id="paymentssearchinput" class="form-control me-2" placeholder="Search by Code/Mode of Payment">
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
                                <?php foreach ($allCardPayments as $u): ?>
                                    <tr>
                                        <td><?= $u['booking_id'] ?></td>
                                        <td><?= htmlspecialchars($u['card_name']) ?></td>
                                        <td><?= htmlspecialchars($u['card_number']) ?></td>
                                        <td><?= htmlspecialchars($u['card_expiry']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <nav style="background-color:f5f5f5; display: flex; align-items: center; justify-content: end; padding: 10px;">
                    <div style="display: flex; align-items: center; margin-right: 20px;">
                        <label style="margin-right: 10px;">Show:</label>
                        <input type="number" limit="1" id="airportViewLimit" style="width: 40px; text-align: center;">
                    </div>

                    <ul class="pagination" id="airport-pagination" style="margin: 0;">
                        <?php for ($p = 1; $p <= $totalCardPages; $p++): ?>
                            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?cardsearchInput=<?= urlencode($searchCard) ?>&page=<?= $p ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>

            </section>
        </div>

    </section>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



    

</body>
</html>

