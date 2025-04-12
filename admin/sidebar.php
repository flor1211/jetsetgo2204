<div style="
    width: 220px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #162447;
    color: white;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.2);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
">
<div>
    <img src="logo.png" alt="hindi na ba ako makakapeaceful?" width="auto" height="auto" style="margin-bottom: 10px;">
    <h2 style="font-size: 22px; margin-bottom: 30px; text-align: center;">JetSetGo</h2>
    <ul style="list-style: none; padding-left: 0;">
      <li style="margin-bottom: 15px;">
        <a href="dashboard.php" style="color: white; text-decoration: none; font-size: 17px;"><i class="bi bi-speedometer2" style="margin-right: 10px;"></i>      Dashboard</a>
      </li>
      <li style="margin-bottom: 15px;">
        <a href="bookings.php" style="color: white; text-decoration: none; font-size: 17px;"><i class="bi bi-journal-bookmark" style="margin-right: 10px;"></i> Bookings</a>
      </li>
      <li style="margin-bottom: 15px;">
        <a href="flights.php" style="color: white; text-decoration: none; font-size: 17px;"><i class="bi bi-airplane" style="margin-right: 10px;"></i> Flights</a>
      </li>
      <li style="margin-bottom: 15px;">
        <a href="airports.php" style="color: white; text-decoration: none; font-size: 17px;"><i class="bi bi-geo-alt-fill" style="margin-right: 10px;"></i> Airports</a>
      </li>
      <li style="margin-bottom: 15px;">
        <a href="planes.php" style="color: white; text-decoration: none; font-size: 17px;"><i class="bi bi-airplane-engines" style="margin-right: 10px;"></i> Planes</a>
      </li>
      <li style="margin-bottom: 15px;">
        <a href="accounts.php" style="color: white; text-decoration: none; font-size: 17px;"><i class="bi bi-person-circle" style="margin-right: 10px;"></i> Accounts</a>
      </li>
    </ul>
  </div>


  <div style="margin-top: auto; text-align: center; font-size: 17px; font-weight:bold;">
    <p>Administrator</p>
    <button id="logoutBtn" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="bi bi-box-arrow-left"></i> Log Out
    </button>
  </div>



  <br>
  <div style="text-align: center; font-size: 12px;">
    <p>&copy; 2025 JetSetGo. All rights reserved.</p>
  </div>
</div>


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





