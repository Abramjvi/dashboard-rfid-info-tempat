<?php

$host = 'localhost';
$username = 'root'; 
$password = '';     

$dbname1 = 'employee_locating_system';
$dbname2 = 'employee_locating_system';

try {
    $pdo_rfid = new PDO("mysql:host=$host;dbname=$dbname1;charset=utf8", $username, $password);
    $pdo_rfid->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo_els = new PDO("mysql:host=$host;dbname=$dbname2;charset=utf8", $username, $password);
    $pdo_els->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
