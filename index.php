<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['username'] = $username;
            $_SESSION['login_success'] = true;
            header("Location: index.php");
            exit();
        } else {
            // Password salah
            $_SESSION['error'] = "Username atau password salah";
            header("Location: index.php");
            exit();
        }
    } else {
        // Username tidak ditemukan
        $_SESSION['error'] = "Username atau password salah";
        header("Location: index.php");
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkir Program</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <link rel="stylesheet" href="style.css">
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

            <button type="submit">Log In</button>
        </form>
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

        if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
            echo "
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: 'Anda berhasil login!',
                    didClose: () => {
                        window.location = 'create.php';
                    }
                });
            ";
            unset($_SESSION['login_success']);
        }
        ?>
    </script>
</body>
</html>
