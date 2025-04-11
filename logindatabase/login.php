<?php session_start();
include "connect.php";
if(isset($_POST["login"])) {
    if($_POST["username"]=="" or $_POST["email"]=="" or $_POST["password"]=="") {
    echo "<center><h1>Username,Email and Password cannot be empty...!</h1></center>";

    }else {
$email=trim($_POST["email"]);
$username=strip_tags(trim($_POST["username"]));
$password=strip_tags(trim($_POST["password"]));
$query=$db->prepare("SELECT * FROM login WHERE email=? AND password=?"); 
$query->execute(array($email, $password));
$control=$query->fetch(PDO:: FETCH_OBJ);
if($control > 0) {
 $_SESSION["username"]=$username;
  header("Location:index.php");
  exit();
}
echo "<center›‹h1›incorrect Password or Email...!</h1></center>";


    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        .wrapper{
            position: absolute;
            top:20%;
            Left:35%;
            padding: 10px;
            border:15px solid red;
            width: 300px;
            height: 250px;
            line-height: 40px;
            text-align: center;
            font-weight: bold:;
        }
     </style>
</head>
<body>
    <div class="wrapper">
        <form method="POST">
            <p>
               <label for="">Username</label>
               <input name="username" type="text">
            </p>
            <p>
               <label for="">Email</label>
               <input name="email" type="text">
            </p>
            <p>
               <label for="">Password</label>
               <input name="password" type="text">
            </p>
        <button type="submit" name="login">Login</button>
        </form>
    </div>

</body>
</html>