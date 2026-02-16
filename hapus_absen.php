<?php
session_start();
include "koneksi.php";

// Cek keamanan
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Ambil ID dari URL
$id = $_GET['id'];

// Hapus data berdasarkan ID
$query = mysqli_query($koneksi, "DELETE FROM absensi WHERE id='$id'");

if ($query) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data'); window.location='admin.php';</script>";
}
?>