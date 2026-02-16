<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_absensi";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Gagal konek ke database: " . mysqli_connect_error());
}
?>