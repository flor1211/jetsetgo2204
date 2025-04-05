<?php
    session_start();
    session_unset();
    session_destroy();


    header("Location: /jetsetgo2204/homepage.php"); 
    exit();
?>
