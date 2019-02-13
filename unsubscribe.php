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
$serverName = "localhost";
$username = "root";
$password = "root";
$dbname = "provaid";

// DB connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// get the type of subscription
$type = $_GET['type'];
// get the ash value
$hash = $_GET['hash'];

// delete DB record depending on subscription type
try {
    $sql = "DELETE FROM $type WHERE hashedemail='$hash'";
    $conn->exec($sql);
    echo "Record deleted successfully";
} 
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

// smtp credentials and server
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'contact.provaid@gmail.com';
$smtpPassword = 'Canaries-2018!';

$mail = new PHPMailer(true);
/*try{    
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
    $mail->Subject = 'New Provaid unsubscription';
    $mail->Body = $messageBody;

    $mail->send();
    echo '200';

} catch(Exception $e){
    echo '404', $mail->ErrorInfo;
}*/

