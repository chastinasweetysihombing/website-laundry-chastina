<?php
session_start();
include "db_laundry.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    // Cek apakah email ada di database
    $sql   = "SELECT * FROM tb_user WHERE email='$email' LIMIT 1";
    $query = mysqli_query($koneksi, $sql);

    if (!$query) {
        die("Query error: " . mysqli_error($koneksi));
    }

    $user = mysqli_fetch_assoc($query);

    if ($user) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil -> simpan session
            $_SESSION['user_id']  = $user['id_user'];   // pastikan nama kolom sesuai
            $_SESSION['username'] = $user['username'];  // ganti 'username' sesuai kolom di tabel
            $_SESSION['role']     = $user['role'];      // ganti 'role' sesuai kolom di tabel

            header("Location: dashboard.php");
            exit;
        } else {
            // Password salah
            header("Location: login.php?error=Password salah!");
            exit;
        }
    } else {
        // Email tidak ditemukan
        header("Location: login.php?error=Email tidak ditemukan!");
        exit;
    }
} else {
    // Jika akses langsung tanpa POST
    header("Location: login.php");
    exit;
}
