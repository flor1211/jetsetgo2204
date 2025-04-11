<?php
require_once 'crud.php';

$user = new Crud();
$editingUser = null;

$search = $_GET['search'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $user->create($_POST['bookname'], $_POST['author']);
        header("Location: index.php?success=1");
        exit;
    }

    if (isset($_POST['update'])) {
        $user->update($_POST['id'], $_POST['bookname'], $_POST['author']);
        header("Location: index.php?updated=1");
        exit;
    }

    if (isset($_POST['delete'])) {
        $user->delete($_POST['delete_id']);
        header("Location: index.php?deleted=1");
        exit;
    }
}

$totalUsers = $user->countUsers($search);
$allUsers = $user->searchUsers($search, $limit, $offset);
$totalPages = ceil($totalUsers / $limit);

?>

<!DOCTYPE html>
<html>
<head>
    <title>ADBMS | Books Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="mb-4">Books Management</h2>

    <!-- Add User Form -->
    <form method="post" class="row g-3 mb-4">      
        <div class="col-md-4">
            <input type="text" name="bookname" class="form-control" placeholder="Book Name" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="author" class="form-control" placeholder="Book Author" required>
        </div>
        <div class="col-md-4">
            <button type="submit" name="create" class="btn btn-primary">Add Book</button>
        </div>
    </form>

    <!-- Search Form -->
    <form method="get" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by Book Name/Author" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-outline-secondary">Search</button>
    </form>

    <!-- Users Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>Book ID</th><th>Book Name</th><th>Author</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $u): ?>
                    <tr>
                        <td><?= $u['Book_ID'] ?></td>
                        <td><?= htmlspecialchars($u['Book_Name']) ?></td>
                        <td><?= htmlspecialchars($u['Author']) ?></td>
                        <td>
                            <!-- Edit Button triggers modal -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $u['Book_ID'] ?>">Edit</button>

                            <!-- Delete Form -->
                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this book?');">
                                <input type="hidden" name="delete_id" value="<?= $u['Book_ID'] ?>">
                                <button type="submit" name="delete" class="btn btn-sm btn-danger">Delete</button>
                            </form>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $u['Book_ID'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $u['Book_ID'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="post" class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Book</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $u['Book_ID'] ?>">
                                            <div class="mb-3">
                                                <label>Book Name</label>
                                                <input type="text" name="bookname" class="form-control" value="<?= htmlspecialchars($u['Book_Name']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Author</label>
                                                <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($u['Author']) ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update" class="btn btn-success">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $p ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- SweetAlert Success Messages -->
<?php if (isset($_GET['success']) || isset($_GET['updated']) || isset($_GET['deleted'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($_GET['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Book added successfully!',
            timer: 2000,
            showConfirmButton: false
        });
        <?php elseif (isset($_GET['updated'])): ?>
        Swal.fire({
            icon: 'info',
            title: 'Updated',
            text: 'Book updated successfully!',
            timer: 2000,
            showConfirmButton: false
        });
        <?php elseif (isset($_GET['deleted'])): ?>
        Swal.fire({
            icon: 'warning',
            title: 'Deleted',
            text: 'Book deleted successfully!',
            timer: 2000,
            showConfirmButton: false
        });
        <?php endif; ?>
    });
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
