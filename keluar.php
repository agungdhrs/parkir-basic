<?php include "koneksi.php";

date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['id_kendaraan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];
    $jam_keluar    = $_POST['jam_keluar'];
    query("UPDATE tb_kendaraan SET jam_keluar='$jam_keluar',status='selesai' WHERE id_kendaraan='$id_kendaraan'");
}

if (isset($_POST['cari_kendaraan'])) {
    $no_kendaraan    = $_POST['no_kendaraan'];
    $jam_keluar    = $_POST['jam_keluar'];

    $data = query("SELECT * FROM tb_kendaraan WHERE no_kendaraan='$no_kendaraan'");
    
    $TotalData = hitung($data);
        
    if ($TotalData == 1) {
        // ada data
        $obj = mysqli_fetch_object($data);
        $tampil = true;

        $jenis_kendaraan = $obj->jenis_kendaraan;

        $lamaparkir = strtotime($jam_keluar) - strtotime($obj->jam_masuk);
        $lamaparkir = ts($lamaparkir);

        // MOTOR 2000/JAM
        // MOBIL 5000/JAM

        // DENDA = LEBIH DARI 3 JAM
        // MOTOR BERUBAH +500
        // MOBIL DITAMBAH +1000 

        if ($jenis_kendaraan == "motor") {
            $m_denda = 500;
            $m_harga = 2000;
        }

        if ($jenis_kendaraan == "mobil") {
            $m_denda = 1000;
            $m_harga = 5000;
        }

        $totalharga        = $m_harga * $lamaparkir;
        $denda             = 0;

        if ($lamaparkir > 3) {
            $jam_dendaparkir = $lamaparkir - 3;
            $totalDenda = $jam_dendaparkir * $m_denda;
            $denda = $totalDenda;
            $totalharga     = $totalharga + $totalDenda;     
        }

        $totalBayar = $totalharga;  

    } else {
        $_SESSION['notif'] = "Tidak ada data ditemukan";
        header("Location: ./keluar.php");
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
            <a href="./create.php">MASUK</a>
            <a class="active" href="#">KELUAR</a>
            <a href="./list.php">LIST AKTIF</a>
			<a href="./user.php">USER</a>
        </div>

        <?php if (!isset($tampil)) { ?>
        <form action="" method="post">

            <?php if (isset($_SESSION['notif'])) { ?>
                <div class="notif">
                    <p><?= $_SESSION['notif'] ?></p>
                </div>

            <?php unset($_SESSION['notif']); } ?>
            
            <label for="">No Kendaraan</label>
            <select name="no_kendaraan" required>
				<option value="">Daftar No Kendaraan</option>
				<?php 
					$query = "SELECT no_kendaraan FROM tb_kendaraan WHERE status='belum selesai'";
					$result = mysqli_query($koneksi, $query);
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<option value='".$row['no_kendaraan']."'>".$row['no_kendaraan']."</option>";
					}
				?>
			</select>

            <label for="">Jam Keluar</label>
            <input name="jam_keluar" type="time" required>

            <input type="hidden" name="cari_kendaraan">

            <button>Cari Kendaraan</button>
        </form>
    <?php } ?>

        <?php if (isset($tampil)) { ?>
        <form action="" method="POST">

            <label for="">No Kendaraan</label>
            <input type="text" disabled value="<?= $obj->no_kendaraan; ?>">

            <label for="">Jenis Kendaraan</label>
            <input type="text" disabled value="<?= $obj->jenis_kendaraan; ?>">

            <label for="">Jam Masuk</label>
            <input type="time" value="<?= $obj->jam_masuk; ?>" disabled>

            <label for="">Jam Keluar</label>
            <input type="time" name="jam_keluar" value="<?= $jam_keluar; ?>" required>

            <label for="">Lama Parkir</label>
            <input type="text" value="<?= intval($lamaparkir); ?> Jam" disabled>

            <label for="">Denda</label>
            <input type="text" value="<?= $denda; ?>" disabled>

            <label for="">Total Harus di bayar</label>
            <input type="text" value="<?= $totalBayar ?>" disabled>
            <input type="hidden" name="id_kendaraan" value="<?= $obj->id_kendaraan; ?>">
            <button>Selesaikan</button>
        </form>
            <?php  } ?>
        <div class="menu">
			<a href="./index.php">LOG OUT</a>
		</div>
    </div>
    
</body>
</html>
