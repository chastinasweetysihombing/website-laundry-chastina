<?php
session_start();
include "koneksi.php";

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id      = $_SESSION['user_id'];
    $jenis_cucian = $_POST['jenis_cucian'];
    $berat        = $_POST['berat'];
    $harga_perkg  = 7000; // contoh harga
    $total_harga  = $berat * $harga_perkg;
    $tanggal      = date("Y-m-d");
    $status       = "Sedang diproses";

    // Simpan ke tb_order
    $stmt = $conn->prepare("INSERT INTO tb_order (user_id, jenis_cucian, berat, total_harga, tanggal, status) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isidss", $user_id, $jenis_cucian, $berat, $total_harga, $tanggal, $status);

    if ($stmt->execute()) {
        // Ambil id_order terakhir
        $id_order = $stmt->insert_id;

        // Redirect ke nota.php
        header("Location: nota.php?id_order=" . $id_order);
        exit;
    } else {
        echo "Gagal menyimpan order!";
    }
}
