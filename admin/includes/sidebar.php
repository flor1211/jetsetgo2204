<!-- <div class="sidebar">
    <div class="logo-details">
        <i class="bi bi-airplane-engines"></i>
        <span class="logo-name">JetSetGo</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="dashboard.php">
                <i class="bi bi-columns-gap"></i>
                <span class="link_name"> Dashboard</span>
            </a>
        </li>
        <li>
            <a href="bookings.php">
                <i class="bi bi-journal-bookmark"></i>
                <span class="link_name"> Bookings</span>
            </a>
        </li>
        <li>
            <a href="flights.php">
                <i class="bi bi-airplane"></i>
                <span class="link_name"> Flights</span>
            </a>
        </li>
        <li>
            <a href="airports.php">
                <i class="bi bi-geo-alt-fill"></i>
                <span class="link_name"> Airports</span>
            </a>
        </li>
        <li>
            <a href="planes.php">
                <i class="bi bi-airplane-engines"></i>
                <span class="link_name"> Planes</span>
            </a>
        </li>
        <li>
            <a href="accounts.php">
                <i class="bi bi-person-circle"></i>
                <span class="link_name"> Accounts</span>
            </a>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle">
                <i class="bi bi-person-circle"> </i>
                <span class="link_name"> Accounts</span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="user-profile.php">User Profile</a></li>
                <li><a href="account-management.php">Account Management</a></li>
            </ul>
        </li>
    </ul>
</div> -->


<div class="sidebar" style="  display: flex; flex-direction: column;  ">
  <div class="logo-details">
          <i class="bi bi-airplane-engines"></i>
          <span class="logo-name">JetSetGo</span>
  </div>

  <nav class="nav flex-column">
    <a href="dashboard.php" class="nav-link">
      <span class="icon">
        <i class="bi bi-columns-gap"></i>
      </span>
      <span class="description">Dashboard</span>
    </a>
    <a href="bookings.php" class="nav-link">
      <span class="icon">
        <i class="bi bi-journal-bookmark"></i>
      </span>
      <span class="description">Bookings</span>
    </a>


        <!-- with dropdown -->
        <!-- <a href="bookings.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#bookingssubmenu" aria-expanded="false" aria-controls="bookingssubmenu">
      <span class="icon">
        <i class="bi bi-journal-bookmark"></i>
      </span>
      <span class="description">Bookings <i class="bi bi-caret-down-fill dropdownicon" style="font-size: 15px; align-items: center; margin-left: 5px;"></i></span>
    </a> -->

        <!-- submenu dropdown -->
    <!-- <div class="sub-menu collapse" id="bookingssubmenu">
      <a href="bookings.php" class="nav-link">
        <span class="icon">
          <i class="bi bi-file-earmark-check"></i>
        </span>
        <span class="description">Booking List</span>
      </a>
      <a href="guestlist.php" class="nav-link">
        <span class="icon">
          <i class="bi bi-file-earmark-check"></i>
        </span>
        <span class="description">Guest List</span>
      </a>
      <a href="transactions.php" class="nav-link">
        <span class="icon">
          <i class="bi bi-file-earmark-check"></i>
        </span>
        <span class="description">Transactions</span>
      </a>
    </div> -->

    <a href="planes.php" class="nav-link">
      <span class="icon">
        <i class="bi bi-airplane-engines"></i>
      </span>
      <span class="description">Planes</span>
    </a>
    <a href="airports.php" class="nav-link">
      <span class="icon">
        <i class="bi bi-geo-alt-fill"></i>
      </span>
      <span class="description">Airports</span>
    </a>
    <a href="flights.php" class="nav-link">
      <span class="icon">
        <i class="bi bi-airplane"></i>
      </span>
      <span class="description">Flights</span>
    </a>
    <!-- with dropdown -->
    <a href="accounts.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#account\ssubmenu" aria-expanded="false" aria-controls="accountssubmenu">
      <span class="icon">
        <i class="bi bi-person-circle"></i>
      </span>
      <span class="description">Accounts <i class="bi bi-caret-down-fill dropdownicon" style="font-size: 15px; align-items: center; margin-left: 5px;"></i></span>
    </a>

        <!-- submenu dropdown -->
    <div class="sub-menu collapse" id="accountssubmenu">
      <a href="userprofile.php" class="nav-link">
        <span class="icon">
          <i class="bi bi-file-earmark-check"></i>
        </span>
        <span class="description">User Profie</span>
      </a>
      <a href="accounts.php" class="nav-link">
        <span class="icon">
          <i class="bi bi-file-earmark-check"></i>
        </span>
        <span class="description">Account Management</span>
      </a>
  </nav>

  <div class="sidebar-footer text-center mt-auto p-3" style="font-size: 15px; color: white; margin-bottom: 20px;">
    <b>JetSetGo 2025</b><br>
    All Rights Reserved
  </div>

</div>