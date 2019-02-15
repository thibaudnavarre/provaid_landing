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

// local DB info
/*$serverName = "localhost";
$username = "root";
$password = "root";
$dbname = "provaid";*/

// ovh DB info
$serverName = "provaidcsdadmin.mysql.db";
$username = "provaidcsdadmin";
$password = "xBgfCTA6AnnN8Mrb";
$dbname = "provaidcsdadmin";

// DB connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// type of the subscription (ngo or vol)
$subscriptionType = $_POST["subscriptionType"];
// subscription email address that will be in the To field of the email.
$subscriptionEmail = $_POST["email"];
// hashed subscription email to secure unsubscribe feature
$hashedEmail = hash('sha256', $subscriptionEmail);
// confirmation email content
$messageBody = $confirmationEmail;

$confirmationEmail = file_get_contents('./assets/emailTemplates/ProvaidConfirmation.html', FALSE, NULL, 0, 37022); // nbr de caractères dans le fichier +19, pourquoi ??? mais ca marche
$confirmationEmail .= "https://www.provaid.com/unsubscribe.html?type=$subscriptionType&value=$hashedEmail"; // A remplacer par l'url de désincription
//exemple de lien de désinscription : https://www.provaid.com/unsubscribe.html?type=$subscriptionType&value=$hashedEmail
$confirmationEmail .= file_get_contents('./assets/emailTemplates/ProvaidConfirmation.html', FALSE, NULL, 37022);

$SQLconfirmation = false;
// insert email and hashedEmail into DB depending on subscription type
try {
    $sql = "INSERT INTO $subscriptionType (email, hashedemail) VALUES ('$subscriptionEmail', '$hashedEmail')";
    $conn->exec($sql);
    echo "New record created successfully";
    $SQLconfirmation = true;

} 
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

// Close DB connection
$conn = null;

if ($SQLconfirmation == true) {
    
    // SMTP credentials and server
    $smtpHost = 'smtp.gmail.com';
    $smtpUsername = 'contact.provaid@gmail.com';
    $smtpPassword = 'Canaries-2018!';
    
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
    
        $mail->setFrom('contact.provaid@gmail.com','Provaid'); // Emetteur
        $mail->addAddress($subscriptionEmail); // Destinataire
        $mail->Subject = 'New Provaid subscription';
        $mail->Body = $confirmationEmail;
        $mail->isHTML(true);
        $mail->send();
        echo '200';
    
    } catch(Exception $e){
        echo '404', $mail->ErrorInfo;
    }
}