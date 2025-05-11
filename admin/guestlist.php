<?php
    session_start();

    require_once '../database/admin-crud.php';

    $user = new Crud();
    $editingUser = null;

    $search = $_GET['guestsearchInput'] ?? '';

    $limit = (int)($_GET['guestViewLimit'] ?? 5);

    $page = max(1, (int)($_GET['page'] ?? 1));
    // $limit = 5;
    $offset = ($page - 1) * $limit;

    $totalGuest = $user->countGuest($search);

    $totalPages = ceil($totalGuest / $limit);

    if (!empty($search)) {
        $allGuests = $user->searchGuestwithLimit($search, $limit, $offset);
    } else {
        $allGuests = $user->searchGuestwithLimit($search, $limit, $offset);
    }

      // Redirect to login if not logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
          header("Location: ../login.php");
          exit;
    }


    // AJAX request: FOR PAGINATION and AUTOMATIC SEARCH
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_start();
    
        if (empty($allGuests)) {
            echo '<tr><td colspan="5" class="text-center text-muted">- No Data Available –</td></tr>';
        } else {
            foreach ($allGuests as $a): ?>
                <tr>
                    <td><?= $a['guest_id'] ?></td>
                    <td><?= htmlspecialchars($a['airport_code']) ?></td>
                    <td><?= htmlspecialchars($a['airport_name']) ?></td>
                    <td><?= htmlspecialchars($a['airport_location']) ?></td>
                </tr>
            <?php endforeach;
        }
    
        $rows = ob_get_clean();
    
        ob_start(); ?>
        <ul class="pagination">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                    <a class="page-link ajax-page" href="#" data-page="<?= $p ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul>
        <?php
        $pagination = ob_get_clean();
    
        echo json_encode([
            'rows' => $rows,
            'pagination' => $pagination
        ]);
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

        <!-- SWEET -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="admin.js"></script>

        <title>JetSetGo | Guest Details</title>

        <link rel="stylesheet" href="admin.css">

        <script>
            window.onerror = function(msg, url, lineNo, columnNo, error) {
                alert("Error: " + msg + " in " + url + " at line " + lineNo);
                return false;
            };
        </script>
        
    </head>
<body>

    <?php include 'includes/sidebar.php'; ?>
        
    <section class="home-section">
        
        <?php include 'includes/navbar.php'; ?>

        <div style="margin-left: 10px; padding: 20px;">
            <h2>Guest Management</h2>

            <section class="p-3">
                <!-- SEARCH BAR -->
                <br>
                <div class="mb-3 d-flex">
                    <input type="text" id="guestSearchInput" class="form-control me-2" placeholder="Search by Code/Name/Location">
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
                                <?php foreach ($allGuests as $u): ?>
                                    <tr>
                                        <td><?= $u['airport_id'] ?></td>
                                        <td><?= htmlspecialchars($u['airport_code']) ?></td>
                                        <td><?= htmlspecialchars($u['airport_name']) ?></td>
                                        <td><?= htmlspecialchars($u['airport_location']) ?></td>
                                    </tr>
                                <?php endforeach?>
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
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?airportsearchInput=<?= urlencode($search) ?>&page=<?= $p ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>

            </section>
        </div>

    </section>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!-- Script for AJAX search and pagination--> 

    <script>
        function loadData(page = 1) {
            const searchValue = document.getElementById('airportsearchInput').value;
            const viewLimit = document.getElementById('airportViewLimit').value || 5;

            fetch('airports.php?airportsearchInput=' + encodeURIComponent(searchValue) + '&page=' + page + '&airportViewLimit=' + viewLimit, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('data').innerHTML = data.rows;
                document.getElementById('airport-pagination').innerHTML = data.pagination;

                // Bind new page buttons
                document.querySelectorAll('.ajax-page').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const newPage = this.dataset.page;
                        loadData(newPage);
                    });
                });
            });
        }


        // Live search
        document.getElementById('airportsearchInput').addEventListener('input', function () {
            loadData(1);
        });

        document.getElementById('airportViewLimit').addEventListener('input', () => {
            loadData(1); // Reset to page 1 when limit changes
        });

        // Initial pagination load (optional on page load)
        document.addEventListener('DOMContentLoaded', function () {
            loadData(<?= $page ?>);
        });
    </script>

    

</body>
</html>