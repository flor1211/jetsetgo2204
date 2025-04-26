<?php
session_start();
$error_message = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JetSetGo - Administrator Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: url('https://architizer-prod.imgix.net/media/mediadata/uploads/1534972217576FLLT1-7.jpg?q=60&auto=format,compress&cs=strip&w=1680') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Open Sans', sans-serif;
      height: 100vh;
    }

    header {
      background-color: #0a244a;
      color: white;
      padding: 10px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 18px;
      font-weight: bold;
    }

    .logo img {
      height: 28px;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin-left: 25px;
      font-size: 14px;
    }

    .login-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: calc(100vh - 60px);
      padding: 20px;
    }

    .login-box {
      background-color: rgba(255, 255, 255, 0.3); 
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 25px rgba(0,0,0,0.2);
      width: 300px;
      text-align: center;
      backdrop-filter: blur(12px);
    }

    .login-box h1 {
      font-family: 'Playfair Display', serif;
      color: #2a63c1;
      font-size: 28px;
      margin-bottom: 5px;
    }

    .login-box h2 {
      font-family: 'Playfair Display', serif;
      color: black;
      font-weight: normal;
      font-size: 16px;
      margin-bottom: 30px;
      letter-spacing: 1px;
    }

    .login-box input {
      width: 100%;
      padding: 10px 15px;
      margin-bottom: 12px;
      border-radius: 20px;
      border: 1px solid #aaa;
      outline: none;
      font-size: 14px;
      background-color: white;
    }

    .forgot-password {
      text-align: right;
      margin-bottom: 15px;
    }

    .forgot-password a {
      font-size: 13px;
      text-decoration: underline;
      color: black;
    }

    .login-box button {
      width: 100%;
      padding: 8px; 
      background-color: #007bff;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 20px;
      cursor: not-allowed;
      opacity: 0.6;
      font-size: 14px; 
    }

    .login-box button:hover {
      background-color: #0056b3;
    }

    .login-box p {
      font-size: 13px;
      margin-top: 12px;
      color: black;
    }

    .login-box p a {
      text-decoration: underline;
      color: black;
      font-size: 13px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">
    <img src="https://img.icons8.com/ios-filled/50/ffffff/airplane-take-off.png" alt="plane icon"/>
    JetSetGo
  </div>
  <nav>
    <a href="#">FLIGHTS</a>
    <a href="#">DEALS & OFFERS</a>
    <a href="#">DESTINATIONS</a>
    <a href="#">CONTACT</a>
    <a href="#">ABOUT US</a>
    <a href="#">LOGIN/ SIGN UP</a>
  </nav>
</header>

<div class="login-wrapper">
  <div class="login-box">
    <h1>JETSETGO</h1>
    <h2>ADMINISTRATOR LOGIN</h2>

    <?php if (!empty($error_message)) : ?>
      <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="#">
      <input type="text" name="username" placeholder="Enter Username" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <div class="forgot-password">
        <a href="#">Forgot password?</a>
      </div>
      <button type="submit" disabled>LOG IN</button>
    </form>
    <p>Don't have an account? <a href="#">Sign Up</a></p>
  </div>
</div>

</body>
</html>
