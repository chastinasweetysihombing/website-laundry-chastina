<?php
include "db_laundry.php"; // koneksi database

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];

    // Cek apakah email sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.location='register.php';</script>";
        exit;
    }

    // Insert ke database
    $sql = "INSERT INTO users (nama, email, password, gender, created_at) 
            VALUES ('$nama', '$email', '$password', '$gender', NOW())";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Registrasi berhasil! Silakan login'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Gagal registrasi!'); window.location='register.php';</script>";
    }
}
?>