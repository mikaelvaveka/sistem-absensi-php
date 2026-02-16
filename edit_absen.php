<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $tgl = $_POST['tanggal'];
    $masuk = $_POST['jam_masuk'];
    $keluar = $_POST['jam_keluar'];

    $update = mysqli_query($koneksi, "UPDATE absensi SET tanggal='$tgl', jam_masuk='$masuk', jam_keluar='$keluar' WHERE id='$id'");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='admin.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Absensi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <div class="container" style="max-width: 500px;">
        <div class="card shadow p-4">
            <h3>Edit Jam Absensi</h3>
            <hr>
            <form method="POST">
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?php echo $row['tanggal']; ?>">
                </div>
                <div class="mb-3">
                    <label>Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" value="<?php echo $row['jam_masuk']; ?>">
                </div>
                <div class="mb-3">
                    <label>Jam Pulang</label>
                    <input type="time" name="jam_keluar" class="form-control" value="<?php echo $row['jam_keluar']; ?>">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="update" class="btn btn-primary w-100">Simpan Perubahan</button>
                    <a href="admin.php" class="btn btn-secondary w-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>