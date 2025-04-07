<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JetSetGo - Flight Booking</title>
    <link rel="stylesheet" href="gstdetails.css" />

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

    
    <div class="container">

        <!--Ganitong 4 divs po ba? -->

        <!-- 1st Div: Title of the Form -->
         
        <div class="div-title">
            <p>Now that you've selected your flight, enter your details.</p>
            <h2>Guest Details</h2>
        </div>

        <!-- 2nd Div: Form -->

        <section class="div-form">
   

        <!-- Left Side -->
        <div class="left-side">
            <h2>Adult 1</h2>
            <h3>Name</h3>

            <div class="form-row">
                <div class="form-field">
                    <label for="titleinput">Title:</label>
                    <input type="text" id="titleinput" name="titleinput" required>
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

            <div class="form-row">
                <div class="form-field">
                    <label for="contact-number">Contact Number*</label>
                    <input type="tel" id="contact-number" name="contact-number" pattern="[0-9]{10}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="email">Email Address*</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="right-side">
            <h2>Date Of Birth</h2>

            <div class="form-row">
                <div class="form-field day-field">
                <label for="dayInput" style="margin-left: 45px;">Day</label>
                    <input type="number" id="dayInput" name="day" style="width: 70px;">
            </div>
                 <div class="form-field">
                    <label for="monthInput">Month</label>
                    <input type="number" id="monthInput" name="month" style="width: 80px;">
                 </div>
                     <div class="form-field">
                     <label for="yearInput">Year</label>
                     <input type="number" id="yearInput" name="year" style="width: 50px;">
                 </div>
            </div>


            <div class="form-row">
                <div class="form-field">
                    <label for="nationalityInput">Nationality*</label>
                    <input type="text" id="nationalityInput" name="nationality">
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="retypeemailInput">Retype Email Address*</label>
                    <input type="email" id="retypedemailInput" name="retypedemail">
                </div>
            </div>
        </div>

    
        </section>
</div>

        <!-- 3rd Div: Policy Form -->

        <section class="policy-form">
        <div class="div-confirmation">
            <input type="checkbox" id="confirm-policy" name="confirm-policy" required>
            <label for="confirm-policy">
                I confirm that I have read, understood, and agree to the updated JetSetGo Privacy Policy. I consent to the collection, use, processing, and sharing of my personal information in accordance therewith.
            </label>
        </div>
        </section>

        <!-- 4th Div: Buttons -->
        <div class="div-buttons">
            <button type="submit" class="back-btn">BACK</button>
            <button type="submit" class="continue-btn">CONTINUE</button>
        </div>

    </div>

</body>
</html>
