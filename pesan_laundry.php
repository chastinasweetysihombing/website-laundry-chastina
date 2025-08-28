  <?php
include 'koneksi.php'; 

if (isset($_POST['pesan'])) {
    $nama   = $_POST['nama'];
    $nomor  = $_POST['nomor'];
    $jenis  = $_POST['jenis'];
    $berat  = $_POST['berat'];

    $note = "Nama: $nama, Nomor: $nomor, Jenis: $jenis";

    $user_id    = 1; 
    $service_id = 1; 
    $order_date = date("Y-m-d H:i:s");
    $status     = "Menunggu";
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO orders (user_id, service_id, order_date, weight_kg, note, status, created_at)
              VALUES ('$user_id', '$service_id', '$order_date', '$berat', '$note', '$status', '$created_at')";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Pesanan berhasil dibuat!'); window.location='nota.php';</script>";
    } else {
        echo "Gagal memesan! " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pemesanan Laundry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("WhatsApp Image 2025-08-11 at 13.54.30_79749f22.jpg");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-image: url("WhatsApp Image 2025-08-12 at 13.05.13_049f9fc9.jpg");
            background-size: cover;
            background-position: center;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pemesanan Laundry</h2>
    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Pelanggan" required>
        <input type="text" name="nomor" placeholder="Nomor Telepon" required>
        <select name="jenis" required>
            <option value="">Pilih Jenis Laundry</option>
            <option value="Cuci Kering">Cuci Kering</option>
            <option value="Cuci Setrika">Cuci + Setrika</option>
            <option value="Setrika Saja">Setrika Saja</option>
        </select>
        <input type="number" name="berat" placeholder="Berat Cucian (Kg)" step="0.1" required>
        <button type="submit" name="pesan">Pesan Sekarang</button>
    </form>
</div>

</body>
</html>