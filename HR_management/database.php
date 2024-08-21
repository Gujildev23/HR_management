<?php

$dsn = "mysql:host=localhost;dbname=factory_workers";
$dbusername = "root";
$dbpassword = "";


try {
    $pdo = new PDO ($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException) {
    echo "Connection Failed". $e->getMessage();     
}