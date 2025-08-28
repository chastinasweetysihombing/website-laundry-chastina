<?php
session_start();
include "koneksi.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Pastikan data dikirim via POST
if (isset($_POST['update_status'])) {
    $id_cucian = intval($_POST['id_cucian']);
    $status = $_POST['status'];

    // Update status cucian
    $stmt = $conn->prepare("UPDATE tb_cucian SET status = ? WHERE id_cucian = ?");
    $stmt->bind_param("si", $status, $id_cucian);

    if ($stmt->execute()) {
        // Jika berhasil, redirect ke dashboard admin
        header("Location: dashboard_admin.php");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal update status cucian: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Jika tidak ada POST, redirect kembali
    header("Location: dashboard_admin.php");
    exit;
}
?>
