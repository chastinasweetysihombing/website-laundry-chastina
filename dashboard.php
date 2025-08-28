<?php
session_start();

// Cek apakah user sudah login dan role-nya user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Ambil data user dari session
$nama  = $_SESSION['nama'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Laundry</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url("WhatsApp Image 2025-08-15 at 13.42.02.jpeg");
            background-size: cover;
            background-attachment: fixed;
        }
        .dashboard {
            width: 80%;
            margin: 50px auto;
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.3);
        }
        h1 { color: #ff66a3; text-align: center; }
        .info { text-align: center; margin-bottom: 20px; }
        .menu { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
        .card { width: 200px; height: 120px; background: #f9f9f9; border-radius: 10px;
                box-shadow: 0px 2px 8px rgba(0,0,0,0.2); display: flex; align-items: center;
                justify-content: center; font-weight: bold; color: #333; cursor: pointer;
                transition: 0.3s; text-decoration: none; }
        .card:hover { background: #ff66a3; color: white; transform: translateY(-5px); }
        .logout { text-align: center; margin-top: 25px; }
        .logout a { background: #ff4d4d; color: white; padding: 10px 20px; border-radius: 8px;
                    text-decoration: none; font-weight: bold; }
        .logout a:hover { background: #e60000; }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Selamat Datang, <?= htmlspecialchars($nama) ?> </h1>
        <div class="info">
            <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        </div>
        <div class="menu">
            <a href="cucian.php" class="card">👕 Cucian</a>
            <a href="laporan.php" class="card">📊 Laporan</a>
            
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
