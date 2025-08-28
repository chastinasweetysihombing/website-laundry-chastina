<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Langganan</title>
</head>
<body>
    <h2>Form Pendaftaran Langganan</h2>
    <form method="POST" action="">
        Nama: <input type="text" name="nama" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        No HP: <input type="text" name="no_hp" required><br><br>
        Alamat: <textarea name="alamat" required></textarea><br><br>
        Paket: 
        <select name="paket">
            <option value="Harian">Harian</option>
            <option value="Mingguan">Mingguan</option>
            <option value="Bulanan">Bulanan</option>
        </select><br><br>
        <button type="submit" name="simpan">Daftar</button>
    </form>

    <?php
    include "koneksi.php";
    if (isset($_POST['simpan'])) {
        $nama    = $_POST['nama'];
        $email   = $_POST['email'];
        $no_hp   = $_POST['no_hp'];
        $alamat  = $_POST['alamat'];
        $paket   = $_POST['paket'];
        $tgl     = date("Y-m-d");

        $sql = "INSERT INTO tb_langganan (nama_pelanggan, email, no_hp, alamat, paket, tanggal_daftar, status) 
                VALUES ('$nama','$email','$no_hp','$alamat','$paket','$tgl','Aktif')";
        if ($conn->query($sql) === TRUE) {
            echo "Pelanggan berhasil didaftarkan!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
</body>
</html>
