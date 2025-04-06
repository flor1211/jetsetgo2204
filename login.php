<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JetSetGo Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Open Sans', sans-serif;
    }

    header {
      background-color: #0b2545;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 30px;
      margin-right: 10px;
    }

    .nav-links {
      display: flex;
      gap: 20px;
      font-size: 14px;
    }

    .nav-links a {
      text-decoration: none;
      color: white;
    }

    .container {
      display: flex;
      height: calc(100vh - 60px);
    }

    .left {
      flex: 1;
      background-color: white;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .left h1 {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      color: #0056d2;
      margin-bottom: 30px;
    }

    .left input {
      width: 250px;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    .left a {
      font-size: 14px;
      color: #000;
      margin-bottom: 20px;
      text-decoration: underline;
    }

    .left button {
      background-color: #007bff;
      color: white;
      padding: 10px 30px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .left p {
      font-size: 14px;
    }

    .left p a {
      text-decoration: underline;
      color: black;
    }

    .right {
      flex: 1;
      background: url('https://architizer-prod.imgix.net/media/mediadata/uploads/1534972217576FLLT1-7.jpg?q=60&auto=format,compress&cs=strip&w=1680') no-repeat center center;
      background-size: cover;
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">
      <img src="https://img.icons8.com/ios-filled/50/ffffff/airplane-take-off.png" alt="plane icon"/>
      <span>JetSetGo</span>
    </div>
    <div class="nav-links">
      <a href="#">FLIGHTS</a>
      <a href="#">DEALS & OFFERS</a>
      <a href="#">DESTINATIONS</a>
      <a href="#">CONTACT</a>
      <a href="#">ABOUT US</a>
      <a href="#">LOGIN/ SIGN UP</a>
    </div>
  </header>

  <div class="container">
    <div class="left">
      <h1>LOGIN</h1>
      <input type="text" placeholder="Enter Username" />
      <input type="password" placeholder="Enter Password" />
      <a href="#">Forgot password?</a>
      <button>LOG IN</button>
      <p>Don't have an account? <a href="#">Sign Up</a></p>
    </div>
    <div class="right"></div>
  </div>

</body>
</html>

ftyf