<?php
include "koneksi.php";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="laporan_cucian.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID','Nama Pelanggan','Layanan','Berat','Harga','Status']);

$cucian = $conn->query("SELECT * FROM tb_cucian ORDER BY id_cucian DESC");
while($row = $cucian->fetch_assoc()){
    fputcsv($output, [
        $row['id_cucian'],
        $row['nama_pelanggan'],
        $row['layanan'],
        $row['berat'],
        $row['harga'],
        $row['status']
    ]);
}
fclose($output);
exit;
