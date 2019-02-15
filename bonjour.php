<?php
// ovh DB info
$servername = "provaidcsdadmin.mysql.db";
$username = "provaidcsdadmin";
$password = "xBgfCTA6AnnN8Mrb";
$dbname = "provaidcsdadmin";
$dbport = "3306";
$dbConnect = "mysql:dbname=".$dbname.";host=".$servername;

// DB connection
try {
    $conn = new PDO($dbConnect, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>