<?php session_start();
if (!isset($_SESSION["username"])){
	header("location:login.php");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initia1-scale=1.0">
    <title>Php Login</title>
</head> 
<body>
  <div>
   <center><h1>
        Welcome <?php echo $_SESSION["username"];?><br>
        Login Success.... <br><br>
        <a href="logout.php">Exit</a>
    </h1></center>

</body>
 </html>