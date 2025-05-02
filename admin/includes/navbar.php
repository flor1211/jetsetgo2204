<?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  $username = $_SESSION['username'] ?? 'Guest';
?>

<nav class="nav-container">
        <div class="sidebar-button">
          <i class="bi bi-list sidebarBtn"></i>

          <span class="dashboard"> Dashboard</span>
        </div>
        <!-- <div class="search-box">
          <input type="text" placeholder="Search..." />
          <i class="bi bi-search"></i>
        </div> -->
        <div class="profile-details dropdown">
          <div class="d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <img src="../assets/profile.png" alt="" />
            <span class="admin-name"><?php echo htmlspecialchars($username); ?></span>
          </div>

          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="userprofile.php">Account Settings</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Log Out</a></li>
          </ul>
        </div>

</nav>


<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            </div>
          <div class="modal-body">
              Are you sure you want to logout?
          </div>
          <div class="modal-footer">
            <a href="../logout.php" class="btn btn-danger">Logout</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

          </div>
        </div>
      </div>
</div>

