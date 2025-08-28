<?php
include "koneksi.php";

// Tambah cucian
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_pelanggan']);
    $layanan = $_POST['layanan'];
    $berat = floatval($_POST['berat']);
    $tanggal = date("Y-m-d H:i:s");

    // harga per kg layanan
    $harga_per_kg = 0;
    if($layanan == "Cuci Kering") $harga_per_kg = 6000;
    elseif($layanan == "Cuci Setrika") $harga_per_kg = 7000;
    elseif($layanan == "Setrika Saja") $harga_per_kg = 5000;

    $harga = $berat * $harga_per_kg;

    $stmt = $conn->prepare("INSERT INTO tb_cucian (nama_pelanggan, layanan, berat, harga, status, tanggal) VALUES (?, ?, ?, ?, 'Dalam Antrian', ?)");
    $stmt->bind_param("ssdss", $nama, $layanan, $berat, $harga, $tanggal);
    $stmt->execute();
    $stmt->close();
}

// Hapus cucian
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM tb_cucian WHERE id_cucian = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: cucian.php");
    exit;
}

// Ambil semua cucian
$result = $conn->query("SELECT * FROM tb_cucian ORDER BY id_cucian DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Cucian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin:0; padding:0;
            background: url("WhatsApp Image 2025-08-23 at 21.10.58_2c3d934b.jpg") no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            width: 90%;
            margin: 30px auto;
            background: rgba(255,255,255,0.95);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        h1 { text-align:center; margin-bottom:20px; }
        table { width:100%; border-collapse: collapse; }
        th, td { padding:10px; border:1px solid #ddd; text-align:center; }
        th { background:#4CAF50; color:#fff; }
        tr:nth-child(even){ background:#f9f9f9; }
        tr:hover { background:#f1f1f1; }
        .btn { padding:6px 12px; border-radius:6px; text-decoration:none; color:#fff; }
        .btn-nota { background:#2196F3; }
        .btn-nota:hover { background:#0b7dda; }
        .btn-del { background:#e74c3c; }
        .btn-del:hover { background:#c44133; }
        form { margin-bottom:20px; display:flex; flex-wrap:wrap; gap:10px; justify-content:center; }
        form input, form select, form button { padding:8px; border-radius:6px; border:1px solid #ccc; }
        form button { background:#4CAF50; color:#fff; border:none; cursor:pointer; }
        form button:hover { background:#45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 Data Cucian</h1>

        <!-- Form Tambah Cucian -->
        <form method="POST">
            <input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan" required>
            <select name="layanan" required>
                <option value="">Pilih Layanan</option>
                <option value="Cuci Kering">Cuci Kering</option>
                <option value="Cuci Setrika">Cuci Setrika</option>
                <option value="Setrika Saja">Setrika Saja</option>
            </select>
            <input type="number" step="0.01" name="berat" placeholder="Berat (Kg)" required>
            <button type="submit" name="tambah">Tambah Cucian</button>
        </form>

        <!-- Tabel Data Cucian -->
        <table>
            <tr>
                <th>ID Cucian</th>
                <th>Nama Pelanggan</th>
                <th>Layanan</th>
                <th>Berat (Kg)</th>
                <th>Harga (Rp)</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php
            if($result && $result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>{$row['id_cucian']}</td>";
                    echo "<td>".htmlspecialchars($row['nama_pelanggan'])."</td>";
                    echo "<td>{$row['layanan']}</td>";
                    echo "<td>{$row['berat']}</td>";
                    echo "<td>Rp ".number_format($row['harga'],0,',','.')."</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>{$row['tanggal']}</td>";
                    echo "<td>
                        <a class='btn btn-del' href='?hapus={$row['id_cucian']}' onclick=\"return confirm('Yakin hapus data?')\">Hapus</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Belum ada data cucian</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
