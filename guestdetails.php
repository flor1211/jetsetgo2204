<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JetSetGo - Flight Booking</title>
    <link rel="stylesheet" href="booking.css" />


    <script src= "booking.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Jaldi&display=swap" rel="stylesheet">

</head>
<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="navbar-left">
            <img src="assets/JetSetGo_Logo-removebg.png" alt="JetSetGo Logo" class="logo" />
            <h1 class="brand-name">JetSetGo</h1>
        </div>
        <div class="navbar-right">
            <button class="cancel-btn">Cancel Booking</button>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    
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

    <!-- dynamic form testing only -->

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

    <section class="policy-form">
        <div class="div-confirmation">
            <input type="checkbox" id="confirm-policy" name="confirm-policy" required>
            <label for="confirm-policy">
                I confirm that I have read, understood, and agree to the updated JetSetGo Privacy Policy. I consent to the collection, use, processing, and sharing of my personal information in accordance therewith.
            </label>
        </div>
    </section>



    <div class="div-buttons">
        <button type="submit" class="back-btn">BACK</button>
        <button type="submit" class="continue-btn">CONTINUE</button>
    </div>

  <!-- result modal - testing only -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Booking Summary</h2>
            <div id="modalContent">

            </div>
        </div>
    </div>


</body>
</html>
