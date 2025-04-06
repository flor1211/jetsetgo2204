
<?php
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("Location: admin/dashboard.php");
        exit;
    }

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // TEST LOGIN
        if ($username === "admin" && $password === "1234") {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["login_success"] = true;
            header("Location: admin/dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
}
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

    <title>JetSetGo</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

  </head>
    <body style="margin: 0;">

    <header>
        <div class="logo">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/airplane-take-off.png" alt="plane icon"/>
        <span>JetSetGo</span>
        </div>
        
        <div class="nav-links">
            <a href="homepage.php">HOME</a>
            <a href="#">GALLERY</a>
            <a href="#">ABOUT</a>
        </div>
    </header>

        <!-- Main Content -->
        <div class="login-container">
            <div class="left">
                <h1>JetSetGo</h1>
                <h2>ADMINISTRATOR LOGIN</h2>
                <form id="loginForm" method="POST" action="">
                    <input type="text" id="username" name="username" placeholder="Enter Username" required/>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required/>
                    <!-- <a href="#">Forgot password?</a> -->
                    <button type="submit">LOG IN</button>
                <!-- <p>Don't have an account? <a href="#">Sign Up</a></p> -->
                </form>

                <p style="color:red;"><?php echo $error; ?></p>

            </div>
            <div class="right"></div>
        </div>


        <!-- Main Container -->
        <div>
            <a href="booking/booking.php" class="btn btn-primary">
              Book Now
            </a>
        </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="admin.js"></script>

  </body>
</html>




