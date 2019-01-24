<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/*
THIS FILE USES PHPMAILER INSTEAD OF THE PHP MAIL() FUNCTION

*  Pour installer composer :
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
* 
* Pour installer phpmailer :
php composer.phar require phpmailer/phpmailer
*/

require 'vendor/autoload.php';


// an email address that will be in the From field of the email.
$fromEmail = $_POST["email"];

$messageBody = $_POST["email"];
// smtp credentials and server

$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'louis.brillet@gmail.com';
$smtpPassword = '316594-LBlb';

$mail = new PHPMailer(true);
try{    
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = $smtpHost;
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;

    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;

    $mail->setFrom('louis.brillet@gmail.com','Provaid.com'); // Emetteur
    $mail->addAddress('louis.brillet@gmail.com'); // destinataire
    $mail->Subject = 'Provaider';
    $mail->Body = $messageBody;

    $mail->send();
    echo '200';

} catch(Exception $e){
    echo '404', $mail->ErrorInfo;
}

