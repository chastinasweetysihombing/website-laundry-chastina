<?php
session_start();
include "koneksi.php";

$error = "";
$success = "";

// Tambah pesanan
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesan'])){
    $nama = trim($_POST['nama']);
    $layanan = $_POST['layanan'];
    $tanggal = $_POST['tanggal'];
    $berat = floatval($_POST['berat']);
    $catatan = trim($_POST['catatan']);
    $status = "Dalam Antrian";

    if($nama && $layanan && $tanggal && $berat > 0){
        $stmt = $conn->prepare("INSERT INTO tb_order (nama_pelanggan, layanan, tanggal, berat, catatan, status_order) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $nama, $layanan, $tanggal, $berat, $catatan, $status);
        if($stmt->execute()){
            $success = "Pemesanan berhasil ditambahkan!";
        } else {
            $error = "Gagal menambahkan pesanan: ".$conn->error;
        }
        $stmt->close();
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}

// Ambil data pemesanan
$result = $conn->query("SELECT * FROM tb_order ORDER BY id_order DESC");
?>

<h1>📝 Formulir Pemesanan Laundry</h1>
<?php if($error): ?><p style="color:red;"><?=$error?></p><?php endif; ?>
<?php if($success): ?><p style="color:green;"><?=$success?></p><?php endif; ?>

<form method="POST" style="margin-bottom:20px;">
    <input type="text" name="nama" placeholder="Nama Pelanggan" required><br><br>
    <select name="layanan" required>
        <option value="">--Pilih Layanan--</option>
        <option value="Cuci Kering">Cuci Kering</option>
        <option value="Cuci Setrika">Cuci Setrika</option>
        <option value="Setrika Saja">Setrika Saja</option>
    </select><br><br>
    <input type="date" name="tanggal" required><br><br>
    <input type="number" step="0.01" name="berat" placeholder="Berat (Kg)" required><br><br>
    <textarea name="catatan" placeholder="Catatan (opsional)"></textarea><br><br>
    <button type="submit" name="pesan">Pesan Laundry</button>
</form>

<h2>📋 Daftar Pemesanan</h2>
<table border="1" cellpadding="8" style="border-collapse:collapse; width:100%;">
    <tr style="background:#4CAF50; color:#fff;">
        <th>ID</th>
        <th>Nama</th>
        <th>Layanan</th>
        <th>Tanggal</th>
        <th>Berat (Kg)</th>
        <th>Catatan</th>
        <th>Status</th>
    </tr>
    <?php
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['id_order']}</td>
                    <td>{$row['nama_pelanggan']}</td>
                    <td>{$row['layanan']}</td>
                    <td>{$row['tanggal']}</td>
                    <td>{$row['berat']}</td>
                    <td>{$row['catatan']}</td>
                    <td>{$row['status_order']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Belum ada pemesanan</td></tr>";
    }
    ?>
</table>
