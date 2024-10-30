<?php include "koneksi.php";

date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['no_kendaraan'])) {
	$no_kendaraan		= $_POST['no_kendaraan'];
	$jenis_kendaraan	= $_POST['jenis_kendaraan'];
	$jam_masuk			= $_POST['jam_masuk'];   

	$x = query("INSERT INTO tb_kendaraan (no_kendaraan,jenis_kendaraan,jam_masuk,jam_keluar,status) VALUES ('$no_kendaraan','$jenis_kendaraan','$jam_masuk','','belum selesai') ");
	if ($x) {
		$_SESSION['notif'] = 'berhasil menambah data';
		header("Location: ./create.php"); 
		die();
	}else{
		$_SESSION['notif'] = 'gagal menambah data'; 
		header("Location: ./create.php");
		die();
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
	<link rel="stylesheet" href="style.css?<?= time() ?>">
	<title>Parkir Program</title>
</head>
<body>

	<div class="container">
		<div class="menu">
			<a class="active" href="#">MASUK</a>
			<a href="./keluar.php">KELUAR</a>
			<a href="./list.php">LIST AKTIF</a>
			<a href="./user.php">USER</a>
		</div>

		<form action="" method="post">

			<?php if (isset($_SESSION['notif'])) { ?>
				<div class="notif">
					<p><?= $_SESSION['notif'] ?></p>
				</div>
			<?php unset($_SESSION['notif']); } ?>
			
			<label for="">No Kendaraan</label>
			<input type="text" required name="no_kendaraan">

			<label for="">Jenis Kendaraan</label>
			<select name="jenis_kendaraan">
				<option value="motor">Motor</option>
				<option value="mobil">Mobil</option>
			</select>

			<label for="">Jam Masuk</label>
			<input name="jam_masuk" type="time" value="<?= date('h:i') ?>" required>

			<button>Tambah</button>
		</form>
		<div class="menu">
			<a href="./index.php">LOG OUT</a>
		</div>
	</div>
	
</body>
</html>
