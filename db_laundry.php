<?php
$host = "localhost";
$user = "root";       // default user di XAMPP
$pass = "";           // default password kosong di XAMPP
$db   = "laundry_db"; // ganti sesuai nama database kamu

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
