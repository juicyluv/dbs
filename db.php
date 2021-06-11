<?php

$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dbs";
$dbport = 3306;

try {
    // try to connect 
    $pdo = new PDO("mysql:host=$dbserver;port=$dbport;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);

    // set the error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // if there is any error, print it
    echo "Connection failed: " . $e->getMessage();
}

?>