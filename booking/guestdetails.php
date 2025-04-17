<?php

  session_start();

  if (!isset($_SESSION['selectflight_completed'])) {
    header('Location: selectflights.php');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_SESSION['guestdetails_completed'] = true;
      header('Location: addons.php');
      exit();
  }

    $selectedDepFlight = $_SESSION['selected_depflight'] ?? null;
    $selectedRetFlight = $_SESSION['selected_retflight'] ?? null;

  
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstap S icons CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- <link href="https://fonts.googleapis.com/css2?family=Jaldi&display=swap" rel="stylesheet"> -->

    <title>JetSetGo</title>

    <link rel="stylesheet" href="booking-style.css">

  </head>
    <body style="margin: 0;">
         <!-- NavBar Container -->
         <div id="navbar-container">
            <script>
                fetch("topbar.php")
                  .then(res => res.text())
                  .then(data => {
                    document.getElementById("navbar-container").innerHTML = data;
                  });
              </script>
        </div>


        <!-- Main Content -->

        <!-- Steps Container -->
        <div id="steps-container">
            <script>
                const currentPage = location.pathname.split("/").pop();
                fetch("stepsbar.php?page=" + currentPage)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("steps-container").innerHTML = data;
                    });
            </script>
        </div>

        <div class="container">
          <div class="div-title">
              <p>Now that you've selected your flight, enter your details.</p>
              <h2>Guest Details</h2>
          </div>
        </div>


        <!-- dynamic form testing only -->
        <div class="div-buttons">
            <button class="continue-btn" id="addGuestBtn">Add New</button>
            <button class="continue-btn" id="resultBtn">Check Result</button>
        </div>
        <!-- CONTAINER FOR GUEST DETAILS -->

        <div class = "details-form" id="detailsFormContainer">

            <div class="details-parent" id="guest1">
                <div class="div1">
                    <h2 class="guest-title">Adult 1</h2>
                    
                </div>
                <div class="div2">
                    <h3>Name</h3>
                    <div class="name-section">

                        <div class="form-field">
                            <label for="titleinput">Title:</label>
                                <select id="titleinput" name="titleinput" required>
                                    <option value="" disabled selected></option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms./Mrs.">Ms./Mrs.</option>
                                </select>
                        </div>

                        <div class="form-field">
                            <label for="first-name">First Name:</label>
                                <input type="text" id="first-name" name="first-name" required>

                        </div>
                        <div class="form-field">
                            <label for="last-name">Last Name:</label>
                                <input type="text" id="last-name" name="last-name" required>
                        </div>
                    </div>


                </div>
                <div class="div3">
                    <h3>Date of Birth</h3>
                    <div class="dob-section">
                            <div class="form-field">
                                <label for="yearInput">Year</label>
                                <select id="yearInput" name="year" class="dob-select">
                                <option value="" disabled selected>Year</option>
                                </select>
                            </div>

                            <div class="form-field">
                                <label for="monthInput">Month</label>
                                <select id="monthInput" name="month" class="dob-select">
                                <option value="" disabled selected>Month</option>
                                </select>
                            </div>

                            <div class="form-field">
                                <label for="dayInput">Day</label>
                                <select id="dayInput" name="day" class="dob-select">
                                <option value="" disabled selected>Day</option>
                                </select>
                            </div>

                    </div>

                </div>
                <div class="div4">
                    <div class="form-field">
                        <label for="contact-number">Contact Number*</label>
                            <input type="tel" id="contact-number" name="contact-number" pattern="[0-9]{10}" required>
                    </div>

                </div>
                <div class="div5">
                    <div class="form-field">
                        <label for="nationalityInput">Nationality*</label>
                            <input type="text" id="nationalityInput" name="nationality" required>
                    </div>
                    
                </div>
                <div class="div6">
                    <div class="form-field">
                        <label for="email">Email Address*</label>
                            <input type="email" id="email" name="email" required>
                    </div>

                </div>  
                <div class="div7">
                    <div class="form-field">
                        <label for="retypeemailInput">Retype Email Address*</label>
                            <input type="email" id="retypedemailInput" name="retypedemail">
                    </div>

                </div>
            </div>

        </div>        

        

        <!-- Main Container -->
        <form method="POST" action="">
            <div class="d-flex justify-content-end gap-2">
                <a class="btn btn-secondary" href="selectflights.php" role="button">BACK</a>
                <button type="submit" class="btn btn-primary">CONTINUE</button>
            </div>
        </form>


          <!-- result modal - testing only -->
        <div id="resultModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="closeModalBtn">&times;</span>
                <h2>Booking Summary</h2>
                <div id="modalContent">

                </div>
            </div>
        </div>

    <script>
        // Pass the PHP session values to JavaScript for debugging purposes
        var selectedDepFlight = "<?php echo isset($_SESSION['selected_depflight']) ? $_SESSION['selected_depflight'] : 'No departing flight selected'; ?>";
        var selectedRetFlight = "<?php echo isset($_SESSION['selected_retflight']) ? $_SESSION['selected_retflight'] : 'No returning flight selected'; ?>";

        // Display the values in a pop-up alert for debugging
        alert("Selected Departing Flight: " + selectedDepFlight + "\nSelected Returning Flight: " + selectedRetFlight);
    </script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="booking.js"></script>

  </body>
</html>