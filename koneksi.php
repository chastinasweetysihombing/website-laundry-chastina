<?php
// koneksi database
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "db_laundry";

$conn = new mysqli($servername, $username, $password, $database);

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>