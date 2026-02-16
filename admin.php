<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Fitur Tambah Karyawan Baru
if (isset($_POST['tambah_karyawan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    mysqli_query($koneksi, "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', 'karyawan')");
    echo "<script>alert('Karyawan Berhasil Ditambahkan');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>Dashboard Admin</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h4 class="mt-4">Laporan Absensi Hari Ini</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengambil data absensi digabung dengan data user
                $sql = "SELECT users.nama, absensi.tanggal, absensi.jam_masuk, absensi.jam_keluar 
                        FROM absensi 
                        JOIN users ON absensi.user_id = users.id 
                        ORDER BY absensi.id DESC";
                $result = mysqli_query($koneksi, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['nama']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>{$row['jam_masuk']}</td>
                        <td>{$row['jam_keluar']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="card mt-5 p-3 bg-light">
            <h5>Tambah Karyawan Baru</h5>
            <form method="POST" class="d-flex gap-2">
                <input type="text" name="nama" placeholder="Nama Lengkap" class="form-control" required>
                <input type="text" name="username" placeholder="Username" class="form-control" required>
                <input type="password" name="password" placeholder="Password" class="form-control" required>
                <button type="submit" name="tambah_karyawan" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>
</body>
</html>