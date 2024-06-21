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
        $_SESSION['error'] = "username sudah ada";
        header("Location: createuser.php");
    }

    // Insert user baru
    $query = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Silakan coba lagi";
        header("Location: createuser.php");
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    <link rel="stylesheet" href="style.css">
    <title>Parkir Program</title>
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
            <input type="password" require name="password">

            <label for="confirm_password">confirm Password</label>
            <input type="password" require name="confirm_password">

            <?php
            if (isset($_SESSION['error'])) { ?>
                <div class="error">
                    <p><?= $_SESSION['error'] ?></p>
                </div>
                <?php unset($_SESSION['error']); 
            } ?>

            <button>REGISTER</button>
        </form>
        <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </div>
</body>
</html>