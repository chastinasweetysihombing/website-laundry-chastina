<?php
session_start();
include "koneksi.php";

// Hanya admin yang bisa akses
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Ambil ID user dari GET
if(!isset($_GET['id'])){
    header("Location: dashboard_admin.php");
    exit;
}

$user_id = intval($_GET['id']);

// Ambil data user
$stmt = $conn->prepare("SELECT id, nama, email FROM tb_user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows != 1){
    echo "User tidak ditemukan!";
    exit;
}
$user = $result->fetch_assoc();
$stmt->close();

// Update user
if(isset($_POST['update'])){
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("UPDATE tb_user SET nama = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama, $email, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Update User</title></head>
<body>
<h2>Update User</h2>
<form method="POST">
    <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
    <button type="submit" name="update">Update</button>
</form>
<a href="dashboard_admin.php">Kembali</a>
</body>
</html>
