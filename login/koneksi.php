<?php
$host = 'localhost'; // Host database Anda, biasanya 'localhost'
$user = 'root'; // Username database Anda, biasanya 'root' untuk XAMPP
$password = ''; // Password database Anda, kosongkan jika tidak ada
$dbname = 'db_urbandrive'; // Nama database Anda

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
