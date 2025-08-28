<?php
include "koneksi.php";

// Ambil data cucian, urut berdasarkan id_cucian
$cucian = $conn->query("SELECT * FROM tb_cucian ORDER BY id_cucian DESC");

// Ambil status logs, urut berdasarkan d_log
$logs = $conn->query("SELECT * FROM status_logs ORDER BY id_log DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Cucian</title>
<style>
body { font-family: Arial; }
table { width:100%; border-collapse: collapse; margin-bottom:20px; }
th,td { border:1px solid #ddd; padding:8px; text-align:center; }
th { background:#4CAF50; color:#fff; }
a.btn { padding:5px 10px; background:#4CAF50; color:#fff; text-decoration:none; border-radius:4px; }
</style>
</head>
<body>
<h1>Laporan Data Cucian</h1>

<a class="btn" href="laporan_csv.php">Download CSV</a>

<table>
<tr><th>ID</th><th>Nama Pelanggan</th><th>Layanan</th><th>Berat</th><th>Harga</th><th>Status</th></tr>
<?php if($cucian->num_rows>0): ?>
<?php while($row=$cucian->fetch_assoc()): ?>
<tr>
<td><?= $row['id_cucian'] ?? '-' ?></td>
<td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
<td><?= $row['layanan'] ?? '-' ?></td>
<td><?= $row['berat'] ?? '-' ?></td>
<td>Rp <?= isset($row['harga']) ? number_format($row['harga'],0,',','.') : '-' ?></td>
<td><?= $row['status'] ?? '-' ?></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6">Tidak ada data</td></tr>
<?php endif; ?>
</table>

<h1>Status Logs</h1>
<table>
<tr><th>ID Log</th><th>ID User</th><th>Status</th><th>Created At</th></tr>
<?php if($logs->num_rows>0): ?>
<?php while($log=$logs->fetch_assoc()): ?>
<tr>
<td><?= $log['id_log'] ?? '-' ?></td>
<td><?= $log['id_user'] ?? '-' ?></td>
<td><?= $log['status'] ?? '-' ?></td>
<td><?= $log['created_at'] ?? '-' ?></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="4">Belum ada log</td></tr>
<?php endif; ?>
</table>
</body>
</html>
