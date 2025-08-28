<?php
session_start();
include "koneksi.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $email    = isset($_POST['email']) ? strtolower(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validasi input
    if (!$nama || !$email || !$password) {
        $error = "❌ Semua field wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Format email tidak valid!";
    } else {
        // Cek apakah email sudah ada
        $stmt = $conn->prepare("SELECT id, nama, email, password FROM tb_user WHERE email=? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $error = "❌ Email sudah terdaftar!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan user baru
            $stmt = $conn->prepare("INSERT INTO tb_user (nama, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->bind_param("sss", $nama, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "✅ Registrasi berhasil! Silakan login.";
            } else {
                $error = "❌ Terjadi kesalahan: " . $conn->error;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Laundry</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url("WhatsApp Image 2025-08-15 at 13.42.02.jpeg");
            background-size: cover;
        }
        .register-box {
            width: 380px;
            margin: 100px auto;
            padding: 30px;
            background: rgba(255,255,255,0.92);
            border-radius: 10px;
            box-shadow: 0px 0px 12px rgba(0,0,0,0.25);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #aaa;
            border-radius: 5px;
            outline: none;
        }
        input:focus {
            border-color: #ff66a3;
            box-shadow: 0 0 5px rgba(255,102,163,0.5);
        }
        button {
            width: 100%;
            padding: 12px;
            background: #ff66a3;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }
        button:hover {
            background: #e05590;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #ff66a3;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Registrasi Laundry</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">DAFTAR</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
