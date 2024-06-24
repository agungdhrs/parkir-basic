<?php 
include "koneksi.php";

$data = query("SELECT * FROM user");
$i = 0;

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
    <title>List User</title>
</head>
<body>
    <div class="container">
        <div class="menu">
            <a href="./create.php">MASUK</a>
			<a href="./keluar.php">KELUAR</a>
			<a href="./list.php">LIST AKTIF</a>
			<a class="active" href="#">USER</a>
        </div>

        <table width="100%" border="1" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Username</th>
            </tr>

            <?php foreach ($data as $k) { ?>
                <tr>
                    <td style="width: 10%;"><?php echo ++$i;?></td>
                    <td><?= $k['username'] ?></td>
                </tr>
            <?php } ?>
        </table>
        <div class="menu">
            <a href="./index.php">LOG OUT</a>
        </div>
    </div>
</body>
</html>