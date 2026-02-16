<?php
session_start();
include "koneksi.php";

// Cek apakah sudah login & role-nya karyawan
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'karyawan') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$tanggal_hari_ini = date('Y-m-d');
$waktu_sekarang = date('H:i:s');

// Cek status absen hari ini
$cek_absen = mysqli_query($koneksi, "SELECT * FROM absensi WHERE user_id='$user_id' AND tanggal='$tanggal_hari_ini'");
$data_absen = mysqli_fetch_assoc($cek_absen);

// Logika Tombol
if (isset($_POST['absen_masuk'])) {
    mysqli_query($koneksi, "INSERT INTO absensi (user_id, tanggal, jam_masuk) VALUES ('$user_id', '$tanggal_hari_ini', '$waktu_sekarang')");
    header("Refresh:0");
}
if (isset($_POST['absen_pulang'])) {
    mysqli_query($koneksi, "UPDATE absensi SET jam_keluar='$waktu_sekarang' WHERE user_id='$user_id' AND tanggal='$tanggal_hari_ini'");
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <div class="container">
        <h1>Halo, <?php echo $_SESSION['nama']; ?>!</h1>
        <p>Tanggal: <?php echo $tanggal_hari_ini; ?></p>
        
        <div class="card mt-4">
            <div class="card-body text-center">
                <?php if (!$data_absen): ?>
                    <h3>Silakan Absen Masuk</h3>
                    <form method="POST">
                        <button type="submit" name="absen_masuk" class="btn btn-success btn-lg">ABSEN MASUK</button>
                    </form>
                <?php elseif ($data_absen['jam_keluar'] == NULL): ?>
                    <h3>Anda Masuk jam: <?php echo $data_absen['jam_masuk']; ?></h3>
                    <p>Klik tombol di bawah jika ingin pulang.</p>
                    <form method="POST">
                        <button type="submit" name="absen_pulang" class="btn btn-warning btn-lg">ABSEN PULANG</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info">
                        Terima kasih! Anda sudah selesai bekerja hari ini.<br>
                        Masuk: <b><?php echo $data_absen['jam_masuk']; ?></b> | 
                        Pulang: <b><?php echo $data_absen['jam_keluar']; ?></b>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>
</html>