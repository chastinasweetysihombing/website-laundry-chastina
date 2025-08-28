<?php
session_start();
include "koneksi.php";

$error = "";
$success = "";

/* ====== TAMBAH PELANGGAN ====== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama    = trim($_POST['nama']);
    $email   = trim($_POST['email']);
    $no_telp = trim($_POST['no_telp']);
    $alamat  = trim($_POST['alamat']);

    if ($nama === "") {
        $error = "Nama wajib diisi.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tb_pelanggan (nama, email, no_telp, alamat) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $email, $no_telp, $alamat);
        if ($stmt->execute()) {
            $success = "Pelanggan berhasil ditambahkan.";
        } else {
            $error = "Gagal menambah pelanggan: " . $conn->error;
        }
        $stmt->close();
    }
}

/* ====== HAPUS PELANGGAN ====== */
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM tb_pelanggan WHERE id_pelanggan = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success = "Data pelanggan berhasil dihapus.";
        } else {
            $error = "Gagal menghapus data.";
        }
        $stmt->close();
    }
}

/* ====== AMBIL DATA ====== */
$result = $conn->query("SELECT id_pelanggan, nama, email, no_telp, alamat FROM tb_pelanggan ORDER BY id_pelanggan DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Data Pelanggan</title>
    <style>
        * { box-sizing: border-box; }
        body{
            margin:0; padding:0; font-family: Arial, sans-serif;
            background: url('background-laundry.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay{
            min-height:100vh;
            background: rgba(255,255,255,0.92);
            padding: 30px 0;
        }
        .container{
            width: 92%;
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            padding: 24px;
        }
        h2{ text-align:center; margin: 0 0 18px; }
        .row{ display:grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card{
            background:#f9fbff; border:1px solid #e6ebf5; border-radius:12px; padding:16px;
        }
        .msg{ text-align:center; margin-bottom:12px; font-weight:600; }
        .msg.error{ color:#d63031; }
        .msg.success{ color:#2d8a34; }
        form label{ display:block; font-size:13px; color:#555; margin-bottom:6px; }
        form input, form textarea, form button{
            width:100%; padding:10px 12px; border:1px solid #cfd8e3; border-radius:8px; outline:none;
        }
        form textarea{ height:80px; resize:vertical; }
        form button{
            background:#4a90e2; color:#fff; font-weight:700; cursor:pointer; border:none; margin-top:6px;
        }
        form button:hover{ background:#3b7ccc; }

        table{
            width:100%; border-collapse: collapse; background:#fff; border-radius:12px; overflow:hidden;
        }
        th, td{ padding:12px; text-align:center; border-bottom:1px solid #eef2f7; }
        th{ background:#4a90e2; color:#fff; }
        tr:nth-child(even){ background:#fafcff; }
        tr:hover{ background:#f2f7ff; }
        .btn{
            display:inline-block; padding:6px 10px; border-radius:6px; text-decoration:none; color:#fff; font-size:13px;
        }
        .btn-del{ background:#e74c3c; }
        .btn-del:hover{ background:#c44133; }
        @media (max-width: 820px){
            .row{ grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="overlay">
    <div class="container">
        <h2>📇 Data Pelanggan</h2>

        <?php if ($error): ?><div class="msg error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="msg success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

        <div class="row">
            <!-- Form Tambah -->
            <div class="card">
                <h3 style="margin-top:0;">Tambah Pelanggan</h3>
                <form method="POST" autocomplete="off">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div>
                            <label>Nama</label>
                            <input type="text" name="nama" required />
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email" />
                        </div>
                        <div>
                            <label>No. Telepon</label>
                            <input type="text" name="no_telp" />
                        </div>
                        <div>
                            <label>Alamat</label>
                            <textarea name="alamat" placeholder="Alamat lengkap"></textarea>
                        </div>
                    </div>
                    <button type="submit" name="tambah">Simpan</button>
                </form>
            </div>

            <!-- Tabel Data -->
            <div class="card">
                <h3 style="margin-top:0;">Daftar Pelanggan</h3>
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id_pelanggan']}</td>
                                        <td>".htmlspecialchars($row['nama'])."</td>
                                        <td>".htmlspecialchars($row['email'])."</td>
                                        <td>".htmlspecialchars($row['no_telp'])."</td>
                                        <td>".htmlspecialchars($row['alamat'])."</td>
                                        <td>
                                            <a href='?hapus={$row['id_pelanggan']}' 
                                               class='btn btn-del'
                                               onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Belum ada data pelanggan.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .overlay -->
</body>
</html>
<?php $conn->close(); ?>
