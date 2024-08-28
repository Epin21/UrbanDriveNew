<?php
// Memulai session untuk login user
session_start();

// Memanggil file koneksi ke database
include "koneksi.php";

// Menangkap data yang dikirim dari form login.php
$email = $_POST['your_name'];
$password = $_POST['your_pass'];

// Query untuk menyeleksi data user dengan email dan password
$query = "SELECT * FROM tb_logreg WHERE email=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$hasil = $stmt->get_result();
$data = $hasil->fetch_assoc();

// Cek apakah user ditemukan
if ($data && password_verify($password, $data['password'])) {
    // Buat session login dan username
    $_SESSION['username'] = $data['nama'];
    $_SESSION['level'] = $data['level'];

    // Alihkan ke halaman sesuai level user
    if ($data['level'] == "admin") {
        header("Location: hal_admin.php");
    } else if ($data['level'] == "user") {
        header("Location: ../index.html");
    } else {
        echo "Anda Bukan Admin dan Bukan User";
        // Alihkan ke halaman login kembali (Opsional)
        // header("Location: login.php");
    }
} else {
    // Jika username dan password tidak ditemukan pada database
    echo "GAGAL LOGIN!!!, Username dan Password tidak ditemukan";
}

// Menutup koneksi
$stmt->close();
$conn->close();
?>
