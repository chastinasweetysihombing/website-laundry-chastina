<?php
// koneksi database
$conn = new mysqli("localhost", "root", "", "laundry");

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama      = $_POST['nama'];
    $berat     = $_POST['berat'];
    $layanan   = $_POST['layanan'];
    $harga_perkg = 7000; // harga default
    if ($layanan == "Express") {
        $harga_perkg = 10000; 
    }

    $total = $berat * $harga_perkg;

    // simpan ke database
    $sql = "INSERT INTO pesanan (nama, berat, layanan, total_harga) 
            VALUES ('$nama', '$berat', '$layanan', '$total')";
    if ($conn->query($sql) === TRUE) {
        $success = "Pesanan berhasil disimpan! Total Rp " . number_format($total,0,',','.');
    } else {
        $success = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pesanan Laundry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            width: 350px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        button {
            background: #4CAF50;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background: #45a049;
        }
        .success {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Pesan Laundry</h2>
        <form method="POST" action="">
            <label>Nama:</label>
            <input type="text" name="nama" required>

            <label>Berat (Kg):</label>
            <input type="number" name="berat" min="1" required>

            <label>Layanan:</label>
            <select name="layanan">
                <option value="Reguler">Reguler</option>
                <option value="Express">Express</option>
            </select>

            <button type="submit">Kirim Pesanan</button>
        </form>
        <?php if (!empty($success)) { ?>
            <div class="success"><?= $success ?></div>
        <?php } ?>
    </div>
</body>
</html>