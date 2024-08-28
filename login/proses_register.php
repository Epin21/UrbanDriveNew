<?php
//memanggil file koneksi.php
include "koneksi.php";

$nama = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$level = "user"; //level otomatis diisi user pd saat registrasi

//format acak password harus sama dengan proses_login.php
$pengacak = "p3ng4c4k";
$password_acak = md5($pengacak.md5($password).$pengacak);

$kirim = isset($_POST['kirim']) ? $_POST['kirim'] : false;

//proses kirim data ke database MYSQL
if($kirim){
    $query = "INSERT INTO tb_user (username, email, password, level, no_hp) VALUES ('$nama', '$email', '$password_acak', '$level', '$no_hp')";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../index.html");
    } else {
        echo "Registrasi User Gagal!";
    }
} else {
    echo "Registrasi User Gagal!";
}
?>