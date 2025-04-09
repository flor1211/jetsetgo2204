<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JetSetGo - Flight Booking</title>
    <link rel="stylesheet" href="old-gstdetails.css" />

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
                        <select id="titleinput" name="titleinput" required>
                            <option value="" disabled selected>Select title</option>
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
        <select id="dayInput" name="day" style="width: 70px;">
            <option value="" disabled selected>Day</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
        </select>
    </div>

    <div class="form-field">
        <label for="monthInput">Month</label>
        <select id="monthInput" name="month" style="width: 80px;">
            <option value="" disabled selected>Month</option>
            <option value="1">Jan</option>
            <option value="2">Feb</option>
            <option value="3">Mar</option>
            <option value="4">Apr</option>
            <option value="5">May</option>
            <option value="6">Jun</option>
            <option value="7">Jul</option>
            <option value="8">Aug</option>
            <option value="9">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>
    </div>

    <div class="form-field">
    <label for="yearInput">Year</label>
    <select id="yearInput" name="year" style="width: 70px;">
        <option value="" disabled selected>Year</option>
        <option value="2025">2025</option>
        <option value="2024">2024</option>
        <option value="2023">2023</option>
        <option value="2022">2022</option>
        <option value="2021">2021</option>
        <option value="2020">2020</option>
        <option value="2019">2019</option>
        <option value="2018">2018</option>
        <option value="2017">2017</option>
        <option value="2016">2016</option>
        <option value="2015">2015</option>
        <option value="2014">2014</option>
        <option value="2013">2013</option>
        <option value="2012">2012</option>
        <option value="2011">2011</option>
        <option value="2010">2010</option>
        <option value="2009">2009</option>
        <option value="2008">2008</option>
        <option value="2007">2007</option>
        <option value="2006">2006</option>
        <option value="2005">2005</option>
        <option value="2004">2004</option>
        <option value="2003">2003</option>
        <option value="2002">2002</option>
        <option value="2001">2001</option>
        <option value="2000">2000</option>
        <option value="1999">1999</option>
        <option value="1998">1998</option>
        <option value="1997">1997</option>
        <option value="1996">1996</option>
        <option value="1995">1995</option>
        <option value="1994">1994</option>
        <option value="1993">1993</option>
        <option value="1992">1992</option>
        <option value="1991">1991</option>
        <option value="1990">1990</option>
    </select>
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
