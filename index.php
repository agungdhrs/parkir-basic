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
            header("Location: create.php");
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

            <?php
            if (isset($_SESSION['error'])) { ?>
                <div class="error">
                    <p><?= $_SESSION['error'] ?></p>
                </div>
                <?php unset($_SESSION['error']); 
            } ?>

            <button>Log In</button>
        </form>
    </div>
</body>
</html>