<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$guests = $_SESSION['guest_details'] ?? [];


foreach ($guests as $index => $guest) {
    try {
        
        $email = htmlspecialchars($guest['email']);

        echo $email;

        $mail->isSMTP();                   
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;    
        $mail->Username   = 'noreply.g6hotelreservation@gmail.com'; 
        $mail->Password   = 'aaaa bbbb cccc dddd';     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
        $mail->Port       = 465; 

        //Recipients
        $mail->setFrom('noreply.g6hotelreservation@gmail.com', 'JetSetGo');
        $mail->addAddress($email);
        $mail->addReplyTo('noreply.g6hotelreservation@gmail.com', 'JetSetGo');

        //Attachments
        $mail->addAttachment('assets/profile.png', 'profile');  

        //Content
        $mail->isHTML(true);                                 
        $mail->Subject = 'Booking Confirmation';
        
        ob_start(); 
        include 'email-template.php'; 
        $receiptHtml = ob_get_clean(); 
        
        $mail->Body = $receiptHtml;
        $mail->AltBody = '';

        $mail->send();

        echo "[$index] Email sent to: " . htmlspecialchars($guest['email']) . "<br>";
        $mail->clearAddresses();

    } catch (Exception $e) {
        echo "[$index] Failed to send to " . htmlspecialchars($guest['email']) . ": {$mail->ErrorInfo}<br>";
    }
}


sleep(2); 
header('Location: booking/bookreceipt.php');
exit();
?>