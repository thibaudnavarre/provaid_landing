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

$confirmationEmail = file_get_contents('./assets/emailTemplates/ProvaidConfirmation.html');


// an email address that will be in the From field of the email.
/*$connection = new MongoClient( "mongodb://provaid-admin:vykXen-vodpaf-xakve1@ds213665.mlab.com:13665/provaid" );
$ngoCollection = $connection->ngo;
$volCollection = $connection->volunteers;*/

$subscriptionType = $_POST["subscriptionType"];
$subscriptionEmail = $_POST["email"];

$hashedEmail = hash('sha256', $subscriptionEmail);
$messageBody = $confirmationEmail;
// smtp credentials and server

$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'contact.provaid@gmail.com';
$smtpPassword = 'Canaries-2018!';

$document = array(
    "email"=>$subscriptionEmail,
    "hashedEmail"=>$hashedEmail,     
);

$mail = new PHPMailer(true);

try{
    /*if($subscriptionType == "NGO") {
        $ngoCollection->insert($document);
    } else { $volCollection->insert($document); }*/

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

    $mail->setFrom('contact.provaid@gmail.com','Provaid'); // Emetteur
    $mail->addAddress('contact.provaid@gmail.com'); // destinataire
    $mail->Subject = 'New Provaid subscription';
    $mail->Body = $messageBody;
    $mail->isHTML(true);
    $mail->send();
    echo '200';

} catch(Exception $e){
    echo '404', $mail->ErrorInfo;
}

