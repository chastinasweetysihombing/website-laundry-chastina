<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BUBBLEBEAR LAUNDRY</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url("WhatsApp Image 2025-08-23 at 21.10.58_2c3d934b.jpg") no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            text-align: center;
            padding: 80px 20px;
            position: relative;
        }
        /* Overlay gelap biar teks lebih jelas */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6); /* transparansi 60% */
            z-index: 0;
        }
        .container {
            position: relative;
            z-index: 1; /* supaya di atas overlay */
            max-width: 700px;
            margin: auto;
            background: rgba(0,0,0,0.6);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }
        h1 { 
            margin-bottom: 15px; 
            color: #ff99cc; /* biar judul pink manis */
        }
        p { 
            font-size: 18px; 
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 5px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn.pink { background: #ff66a3; color: #fff; }
        .btn.pink:hover { background: #e05590; }
        .btn.gray { background: #eee; color: #333; }
        .btn.gray:hover { background: #ccc; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di BUBBLEBEAR LAUNDRY</h1>
        <p>
            Kalau wangi bajumu bikin aku betah deket, berarti laundry kita berhasil bikin kamu makin istimewa ✨👕<br><br>
            Cucianmu aja aku jaga sampai bersih, apalagi hatimu kalau kamu mau 🫣.<br><br>
            Kalau kangen kamu butuh alasan, cukup lihat bajumu yang wangi setelah laundry di sini.
        </p>
        <a href="login.php" class="btn pink">Login</a>
        <a href="register.php" class="btn gray">Daftar</a>
    </div>
</body>
</html>
