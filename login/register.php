<?php
session_start();
include 'koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully!";
}
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menggunakan field yang sesuai dengan form HTML
    $nama = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['pass']);

    if (!$email) {
        $error_message = "Email tidak valid.";
    } else {
        // Cek apakah email sudah ada
        $check_email_sql = "SELECT * FROM tb_logreg WHERE email=?";
        $check_stmt = $conn->prepare($check_email_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error_message = "Email sudah digunakan.";
        } else {
            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            

            // Query untuk menyimpan data ke tabel login_system
            $sql = "INSERT INTO tb_logreg (nama, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nama, $email, $hashed_password);

            if ($stmt->execute()) {
                // Setelah pendaftaran berhasil, simpan informasi pengguna ke dalam sesi
                $_SESSION['nama'] = $nama;

                // Arahkan ke halaman user-home
                header("Location: ../index.html");
                exit();
            } else {
                $error_message = "Terjadi kesalahan: " . $stmt->error;
            }

            $stmt->close();
        }

        $check_stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up UrbanDrive</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" action="register.php" class="register-form" id="register-form">
                            <div class="form-group"> 
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image">
                        <figure><img src="images/register.png" alt="sing up image"></figure>
                        <figure><img src="images/Screenshot 2024-08-08 202546.png" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

        

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>