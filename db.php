<?php

$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dbs";
$dbport = 3306;

try {
    // try to connect 
    $pdo = new PDO("mysql:host=$dbserver;port=$dbport;dbname=$dbname", $dbusername, $dbpassword);

    // set the error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->query("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // if there is any error, print it
    echo "Connection failed: " . $e->getMessage();
}

?>