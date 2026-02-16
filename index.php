<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Ubah password jadi kode rahasia

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: karyawan.php");
        }
    } else {
        echo "<script>alert('Username atau Password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Absensi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="text-center">Sistem Absensi</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
</body>
</html>