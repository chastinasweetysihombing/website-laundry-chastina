<?php
include 'koneksi.php';

if(isset($_POST['submit'])){
    $id_cucian = $_POST['id_cucian'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO laporan.php (id_cucian, status) VALUES (?, ?)");
    $stmt->bind_param("is", $id_cucian, $status);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo "Status berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan status.";
    }
}
?>

<form method="POST">
    <label>ID Cucian:</label>
    <input type="number" name="id_cucian" required><br>

    <label>Status:</label>
    <select name="status">
        <option value="Diterima">Diterima</option>
        <option value="Dicuci">Dicuci</option>
        <option value="Selesai">Selesai</option>
        <option value="Diambil">Diambil</option>
    </select><br>

    <button type="submit" name="submit">Tambah Status</button>
</form>
