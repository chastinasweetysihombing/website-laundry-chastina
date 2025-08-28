<?php
session_start();
include "koneksi.php";

// Cek login admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: login.php");
    exit;
}

$nama  = $_SESSION['nama'];
$email = $_SESSION['email'];

// Hapus user
if(isset($_GET['delete_user'])){
    $user_id = intval($_GET['delete_user']);
    $stmt = $conn->prepare("DELETE FROM tb_user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard_admin.php");
    exit;
}

// Hapus cucian
if(isset($_GET['hapus_cucian'])){
    $id_cucian = intval($_GET['hapus_cucian']);
    $stmt = $conn->prepare("DELETE FROM tb_cucian WHERE id_cucian = ?");
    $stmt->bind_param("i", $id_cucian);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard_admin.php");
    exit;
}

// Update status cucian
if(isset($_POST['update_status'])){
    $id_cucian = intval($_POST['id_cucian']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE tb_cucian SET status = ? WHERE id_cucian = ?");
    $stmt->bind_param("si", $status, $id_cucian);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard_admin.php");
    exit;
}

// Ambil data user & cucian
$users = $conn->query("SELECT id,nama,email FROM tb_user WHERE role='user'");
$cucian = $conn->query("SELECT * FROM tb_cucian ORDER BY id_cucian DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<style>
body { font-family: Arial; margin:0; background-image:url("WhatsApp Image 2025-08-19 at 21.46.41_d3d2e282 - Copy.jpg") }
.dashboard { width:90%; margin:20px auto; background:#fff; padding:20px; border-radius:10px; }
h1,h2 { color:#ff66a3; }
table { width:100%; border-collapse: collapse; margin-bottom:20px; }
th,td { border:1px solid #ddd; padding:8px; text-align:center; }
th { background:#ff66a3; color:#fff; }
a.btn { padding:5px 10px; border-radius:5px; color:#fff; text-decoration:none; }
.btn-hapus { background:#e74c3c; }
.btn-hapus:hover { background:#c44133; }
form select { padding:5px; }
form button { padding:5px 8px; background:#4CAF50; color:#fff; border:none; border-radius:4px; cursor:pointer; }
form button:hover { background:#45a049; }
</style>
</head>
<body>
<div class="dashboard">
<h1>Selamat Datang, <?= htmlspecialchars($nama) ?></h1>
<p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>

<h2>Daftar User</h2>
<table>
<tr><th>ID</th><th>Nama</th><th>Email</th><th>Aksi</th></tr>
<?php if($users->num_rows>0): ?>
<?php while($user=$users->fetch_assoc()): ?>
<tr>
<td><?= $user['id'] ?></td>
<td><?= htmlspecialchars($user['nama']) ?></td>
<td><?= htmlspecialchars($user['email']) ?></td>
<td>
<a class="btn btn-hapus" href="?delete_user=<?= $user['id'] ?>" onclick="return confirm('Yakin hapus user?')">Hapus</a>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="4">Tidak ada user</td></tr>
<?php endif; ?>
</table>

<h2>Data Cucian</h2>
<table>
<tr><th>ID</th><th>Nama Pelanggan</th><th>Layanan</th><th>Berat</th><th>Harga</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
<?php if($cucian->num_rows>0): ?>
<?php while($row=$cucian->fetch_assoc()): ?>
<tr>
<td><?= $row['id_cucian'] ?></td>
<td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
<td><?= $row['layanan'] ?></td>
<td><?= $row['berat'] ?></td>
<td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
<td>
<form method="POST" style="margin:0;">
<input type="hidden" name="id_cucian" value="<?= $row['id_cucian'] ?>">
<select name="status">
<option value="Dalam Antrian" <?= $row['status']=='Dalam Antrian'?'selected':'' ?>>Dalam Antrian</option>
<option value="Sedang Diproses" <?= $row['status']=='Sedang Diproses'?'selected':'' ?>>Sedang Diproses</option>
<option value="Sedang Dalam Perjalanan" <?= $row['status']=='Sedang Dalam Perjalanan'?'selected':'' ?>>Sedang Dalam Perjalanan</option>
<option value="Sedang Diantar" <?= $row['status']=='Sedang Diantar'?'selected':'' ?>>Sedang Diantar</option>
<option value="Selesai" <?= $row['status']=='Selesai'?'selected':'' ?>>Selesai</option>
</select>
<button type="submit" name="update_status">Update</button>
</form>
</td>
<td><?= $row['tanggal'] ?></td>
<td>
<a class="btn btn-hapus" href="?hapus_cucian=<?= $row['id_cucian'] ?>" onclick="return confirm('Yakin hapus cucian ini?')">Hapus</a>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="8">Belum ada data cucian</td></tr>
<?php endif; ?>
</table>
<a href="logout.php">Logout</a>
</div>
</body>
</html>
