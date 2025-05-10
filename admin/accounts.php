<?php
    session_start();

    require_once '../database/admin-crud.php';

    
    $user = new Crud();
    $editingUser = null;

          // Redirect to login if not logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: ../login.php");
            exit;
    }
  
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
          if(isset($_POST['add'])) {
              $user->addAccount($_POST['newUsername'], $_POST['newPassword'], $_POST['newRole']);
              header("Location: accounts.php?success=1");
              exit;
          }
  
  
          if (isset($_POST['update'])) {
            $user->updateAccount($_POST['accountId'], $_POST['username'], $_POST['password'], $_POST['role']);
            header("Location: accounts.php?updated=1");
            exit;
        }
              
          if(isset($_POST['delete'])) {
  
              $user->deleteAccount($_POST['accountId']);
              header("Location: accounts.php?deleted=1");
              exit;
  
          }
    }
  
    $search = $_GET['accountsearchInput'] ?? '';

    $limit = (int)($_GET['accountViewLimit'] ?? 5);

    $page = max(1, (int)($_GET['page'] ?? 1));
    // $limit = 5;
    $offset = ($page - 1) * $limit;

    $totalAccounts = $user->countAccounts($search);

    $totalPages = ceil($totalAccounts / $limit);

    if (!empty($search)) {
        // $allAccounts = $user->searchAccount($search);
        $allAccounts = $user->searchAccountswithLimit($search, $limit, $offset);
    } else {
        // $allAccounts = $user->getAllAccounts();
        $allAccounts = $user->searchAccountswithLimit($search, $limit, $offset);
    }
    
    // AJAX request: FOR AUTOMATIC SEARCH
    // if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    
    //         if (empty($allAccounts)){
    //             echo '<tr><td colspan="5" class="text-center text-muted">- No Data Available –</td></tr>';           
    //         } else {    
    //             foreach ($allAccounts as $a): ?/>
    //                 <tr>
    //                     <td><?= $a['account_id'] ?/></td>
    //                     <td><?= htmlspecialchars($a['account_username']) ?/></td>
    //                     <!-- <td></?= htmlspecialchars($a['account_password']) ?/></td> -->
    //                     <td><?= htmlspecialchars($a['account_role']) ?/></td>
    //                     <td>    

    //                     <!-- EDIT -->  
    //                     <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAccount<?= $a['account_id']?/>" ><i class="bi bi-pencil-square"></i> Edit</button>
                                          
    //                     <!-- Delete -->
    //                     <form method="post" class="d-inline" onsubmit="return confirm('Delete this account?');">
    //                     <input type="hidden" name="accountId" value="<?= $a['account_id'] ?/>">
    //                     <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
    //                     </form>
    //                     </td>
    //                 </tr>
            
    //             <?php endforeach;
    //         }
    //         exit;
    //     }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_start();
    
        if (empty($allAccounts)) {
            echo '<tr><td colspan="5" class="text-center text-muted">- No Data Available –</td></tr>';
        } else {
            foreach ($allAccounts as $a): ?>
                <tr>
                    <td><?= $a['account_id'] ?></td>
                    <td><?= htmlspecialchars($a['account_username']) ?></td>
                    <!-- <td></?= htmlspecialchars($a['account_password']) ?></td> -->
                    <td><?= htmlspecialchars($a['account_role']) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAccount<?= $a['account_id'] ?>"><i class="bi bi-pencil-square"></i> Edit</button>
                        <form method="post" class="d-inline" onsubmit="return confirm('Delete this account?');">
                            <input type="hidden" name="accountId" value="<?= $a['account_id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
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

    <?php include 'includes/sidebar.php'; ?>
        
    <section class="home-section">
        
        <?php include 'includes/navbar.php'; ?>

        <div style="margin-left: 10px; padding: 20px;">
            <h2>Account Management</h2>
            <section class="p-3">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h3 class="m-0">User Accounts</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccount">
                            <i class="bi bi-person-circle"></i>  New Account
                        </button>
                    </div>    
                </div>

                <!-- SEARCH BAR -->
                <br>
                <div class="mb-3 d-flex">
                    <input type="text" id="accountsearchInput" class="form-control me-2" placeholder="Search by ID/Username/Role">
                </div>

                <!-- TABLE --> 
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mt-3 text-center table-bordered">
                            <thead style="background-color: white;">
                                  <tr>
                                      <th>#</th>
                                      <th>Username</th>
                                      <!-- <th>Password</th> -->
                                      <th>Role</th>
                                      <th>Action</th>
                                  </tr>
                            </thead>
                            <tbody id="data">
                                <?php foreach ($allAccounts as $u): ?>
                                    <tr>
                                        <td><?= $u['account_id'] ?></td>
                                        <td><?= htmlspecialchars($u['account_username']) ?></td>
                                        <!-- <td></?= htmlspecialchars($u['account_password']) ?></td> -->
                                        <td><?= htmlspecialchars($u['account_role']) ?></td>
                                        <td>
                                        <!-- EDIT -->  
                                          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAccount<?= $u['account_id']?>" ><i class="bi bi-pencil-square"></i> Edit</button>
                                        <!-- Delete -->
                                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this account?');">
                                                <input type="hidden" name="accountId" value="<?= $u['account_id'] ?>">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Edit Data Modal-->
                                    <div class="modal fade" id="editAccount<?= $u['account_id'] ?>">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Account Details</h4>
                                                    </div>
                                                    <form  action="" id="editAccountForm<?= $u['account_id'] ?>" method="POST">

                                                        <div class="modal-body">
                                                            <div class="row g-3" style="padding-left: 50px; padding-right: 50px; padding-bottom: 30px;">

                                                                    <input type="hidden" name="accountId" id="accountId" value="<?= ($u['account_id']) ?>">
                                                                <div class="col-md-6">
                                                                    <label class="col-sm-2 col-form-label" for="name">Username</label>
                                                                    <input class="form-control" type="text" name="username" id="username<?= $u['account_id'] ?>" value="<?= htmlspecialchars($u['account_username']) ?>" >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="col-sm-2 col-form-label" for="name">Password</label>
                                                                    <input class="form-control" type="text" name="password" id="password<?= $u['account_id'] ?>" value="">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="col-sm-2 col-form-label" for="name">Role</label>
                                                                        <select class="form-control" id="role<?= $u['account_id'] ?>" name="role">
                                                                            <option value="Administrator" <?= $u['account_role'] == 'Administrator' ? 'selected' : '' ?>>Administrator</option>
                                                                            <option value="Front Desk" <?= $u['account_role'] == 'Front Desk' ? 'selected' : '' ?>>Front Desk</option>
                                                                            <!-- <option value="customer" </?= $u['account_role'] == 'customer' ? 'selected' : '' ?>>Customer</option> -->
                                                                        </select>
                                                                </div>
                                                                

                                                            </div>

                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                                <button type="submit" name="update" form="editAccountForm<?= $u['account_id'] ?>" class="btn btn-primary">Save Changes</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                    </div>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- <nav style="background-color: #f5f5f5; ">
                    <div style="display: flex; align-items: center;">
                        <label style="margin-right: 10px;">Show:</label>
                        <input type="text" id="viewLimit" style="width: 40px; text-align: center;">
                    </div>

                    <ul class="pagination" id="account-pagination" style="padding-right: 10px;" >
                        </?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <li class="page-item </?= $p == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?accountsearchInput=</?= urlencode($search) ?>&page=</?= $p ?>"></?= $p ?></a>
                            </li>
                        </?php endfor; ?>
                        
                    </ul>
                </nav> -->
                <nav style="background-color:f5f5f5; display: flex; align-items: center; justify-content: end; padding: 10px;">
                    <div style="display: flex; align-items: center; margin-right: 20px;">
                        <label style="margin-right: 10px;">Show:</label>
                        <input type="number" limit="1" id="accountViewLimit" style="width: 40px; text-align: center;">
                    </div>

                    <ul class="pagination" id="account-pagination" style="margin: 0;">
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?accountsearchInput=<?= urlencode($search) ?>&page=<?= $p ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>


            </section>
        </div>
    </section>

<!-- --------------------------------------------- --> 
    <!-- ADD MODAL -->
    <div class="modal fade" id="addAccount">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                    
                    <div class="modal-header">
                        <h4 class="modal-title">New Account</h4>

                    </div>

                    <form action="#" id="addAccountForm" method="POST">
                        <div class="modal-body">
                            <div class="row g-3" style="padding-left: 50px; padding-right: 50px; padding-bottom: 30px;">
                                <div class="col-md-6">
                                    <label class="col-sm-2 col-form-label" for="newUsername">Username</label>
                                    <input class="form-control" type="text" name="newUsername" id="newUsername">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-sm-2 col-form-label" for="newPassword">Password</label>
                                    <input class="form-control" type="text" name="newPassword" id="newPassword">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-2 col-form-label" for="name">Role</label>
                                        <select class="form-control" id="newRole" name="newRole" value="">
                                            <option value="" selected disabled hidden>-- Select Role --</option>
                                            <option value="Administrator">Administrator</option>
                                            <option value="Front Desk">Front Desk</option>
                                            <!-- <option value="customer">Customer</option> -->
                                        </select>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" name="add" class="btn btn-primary submit">Add</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>

                    </div>
                </div>
    </div>
  
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- JAVASCRIPT --> 
    <script src="admin-js.js"></script>

    <!-- SweetAlert Messages -->
    <?php if (isset($_GET['success']) || isset($_GET['updated']) || isset($_GET['deleted'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    <?php if (isset($_GET['success'])): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Account added successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    <?php elseif (isset($_GET['updated'])): ?>
                    Swal.fire({
                        icon: 'info',
                        title: 'Updated',
                        text: 'Account updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    <?php elseif (isset($_GET['deleted'])): ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Deleted',
                        text: 'Account deleted successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    <?php endif; ?>
                });
            </script>
    <?php endif; ?> 

    <!-- Script for AJAX search--> 
    <!-- <script>
            document.getElementById('accountsearchInput').addEventListener('input', function () {
                const searchValue = this.value;

                fetch('accounts.php?search=' + encodeURIComponent(searchValue), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('data').innerHTML = data;
                });
            });
    </script>    -->

    <script>
        function loadData(page = 1) {
            const searchValue = document.getElementById('accountsearchInput').value;
            const viewLimit = document.getElementById('accountViewLimit').value || 5;

            fetch('accounts.php?accountsearchInput=' + encodeURIComponent(searchValue) + '&page=' + page + '&accountViewLimit=' + viewLimit, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('data').innerHTML = data.rows;
                document.getElementById('account-pagination').innerHTML = data.pagination;

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
        document.getElementById('accountsearchInput').addEventListener('input', function () {
            loadData(1);
        });

        document.getElementById('accountViewLimit').addEventListener('input', () => {
            loadData(1); // Reset to page 1 when limit changes
        });

        // Initial pagination load (optional on page load)
        document.addEventListener('DOMContentLoaded', function () {
            loadData(<?= $page ?>);
        });
    </script>


</body>
</html>
