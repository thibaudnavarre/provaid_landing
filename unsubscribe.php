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
$servername = "provaidcsdadmin.mysql.db";
$username = "provaidcsdadmin";
$password = "xBgfCTA6AnnN8Mrb";
$dbname = "provaidcsdadmin";

$dbConnect = "mysql:dbname=".$dbname.";host=".$servername;

// DB connection
try {
    $conn = new PDO($dbConnect, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
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
    echo '200';
} 
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}