<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('WhatsApp Image 2025-08-23 at 21.10.58_2c3d934b.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            width: 90%;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin-bottom: 10px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Data Transaksi</h2>

        <!-- Tombol Tambah Transaksi -->
        <a href="tambah_transaksi.php" class="btn">+ Tambah Transaksi</a>

        <table>
            <tr>
                <th>ID Transaksi</th>
                <th>ID Cucian</th>
                <th>Metode Bayar</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
            <?php
            include "koneksi.php";
            $result = $conn->query("SELECT * FROM tb_transaksi");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_transaksi']}</td>
                            <td>{$row['id_cucian']}</td>
                            <td>{$row['metode_bayar']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['tanggal']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Belum ada transaksi</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
