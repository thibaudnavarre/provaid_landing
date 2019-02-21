<?php

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
$senderEmail = $_POST["email"];
$messageBody = $_POST["message"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$messageBody .= "\n" . $firstname . " " . $lastname;

// smtp credentials and server

$smtpHost = 'SSL0.OVH.NET';
$smtpUsername = 'contact@provaid.com';
$smtpPassword = 'ftB3oEGcJLSM';
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->Host = $smtpHost;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';

    $mail->setFrom('contact@provaid.com', 'Provaid Contact'); // Emetteur
    $mail->addAddress('contact.provaid@gmail.com'); // Destinataire
    $mail->Subject = 'Provaid.com - Message from ' . $firstname . ' ' . $lastname;
    $mail->Body = $messageBody;

    $mail->send();
    echo '200';

} catch (Exception $e) {
    echo '404', $mail->ErrorInfo;
}
