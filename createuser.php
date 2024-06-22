<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    if ($password != $confirm_password) {
        $_SESSION['error'] = "Password tidak cocok";
        header("Location: createuser.php");
        exit();
    }

    // Hash password sebelum post
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek username
    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Username sudah ada";
        header("Location: createuser.php");
        exit();
    }

    // Insert user baru
    $query = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['register_success'] = true;
        header("Location: createuser.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Silakan coba lagi";
        header("Location: createuser.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <link rel="stylesheet" href="style.css">
    <title>Parkir Program</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="menu">
            <a href="./createuser.php">REGISTER AKUN</a>
        </div>

        <form action="" method="post">
            <label for="">Username</label>
            <input type="text" required name="username">

            <label for="">Password</label>
            <input type="password" required name="password">

            <label for="confirm_password">Confirm Password</label>
            <input type="password" required name="confirm_password">

            <button>REGISTER</button>
        </form>
        <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </div>
    <script>
        <?php
        if (isset($_SESSION['error'])) {
            echo "
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '".$_SESSION['error']."'
                });
            ";
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['register_success'])) {
            echo "
                Swal.fire({
                    icon: 'success',
                    title: 'Register Berhasil',
                    text: 'Anda berhasil membuat akun!',
                    didClose: () => {
                        window.location = 'index.php';
                    }
                });
            ";
            unset($_SESSION['register_success']);
        }
        ?>
    </script>
</body>
</html>
