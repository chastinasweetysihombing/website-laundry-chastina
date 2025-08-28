<?php
session_start();
include "koneksi.php";

// Admin harus login
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: dashboard_admin.php");
    exit;
}

$id_cucian = intval($_GET['id']);

// Ambil data cucian
$stmt = $conn->prepare("SELECT * FROM tb_cucian WHERE id_cucian = ?");
$stmt->bind_param("i", $id_cucian);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows != 1){
    echo "Data cucian tidak ditemukan!";
    exit;
}
$cucian = $result->fetch_assoc();
$stmt->close();

// Update cucian
if(isset($_POST['update'])){
    $nama_pelanggan = trim($_POST['nama_pelanggan']);
    $layanan = $_POST['layanan'];
    $berat = floatval($_POST['berat']);
    $status = $_POST['status'];

    // Update harga otomatis
    $harga_per_kg = 0;
    if($layanan=="Cuci Kering") $harga_per_kg=6000;
    elseif($layanan=="Cuci Setrika") $harga_per_kg=7000;
    elseif($layanan=="Setrika Saja") $harga_per_kg=5000;

    $harga = $berat * $harga_per_kg;

    $stmt = $conn->prepare("UPDATE tb_cucian SET nama_pelanggan=?, layanan=?, berat=?, harga=?, status=? WHERE id_cucian=?");
    $stmt->bind_param("ssdssi", $nama_pelanggan, $layanan, $berat, $harga, $status, $id_cucian);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Update Cucian</title></head>
<body>
<h2>Update Cucian</h2>
<form method="POST">
    <input type="text" name="nama_pelanggan" value="<?= htmlspecialchars($cucian['nama_pelanggan']) ?>" required><br>
    <select name="layanan" required>
        <option value="Cuci Kering" <?= $cucian['layanan']=='Cuci Kering'?'selected':'' ?>>Cuci Kering</option>
        <option value="Cuci Setrika" <?= $cucian['layanan']=='Cuci Setrika'?'selected':'' ?>>Cuci Setrika</option>
        <option value="Setrika Saja" <?= $cucian['layanan']=='Setrika Saja'?'selected':'' ?>>Setrika Saja</option>
    </select><br>
    <input type="number" step="0.01" name="berat" value="<?= $cucian['berat'] ?>" required><br>
    <select name="status" required>
        <option value="Dalam Antrian" <?= $cucian['status']=='Dalam Antrian'?'selected':'' ?>>Dalam Antrian</option>
        <option value="Sedang Diproses" <?= $cucian['status']=='Sedang Diproses'?'selected':'' ?>>Sedang Diproses</option>
        <option value="Selesai" <?= $cucian['status']=='Selesai'?'selected':'' ?>>Selesai</option>
    </select><br>
    <button type="submit" name="update">Update</button>
</form>
<a href="dashboard_admin.php">Kembali</a>
</body>
</html>
