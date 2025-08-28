<?php
include "koneksi.php"; // pastikan koneksi ke database

$email_admin = "admin@example.com"; // ganti sesuai email admin di DB
$password_lama = "admin"; // password lama

// buat hash
$hashed_password = password_hash($password_lama, PASSWORD_DEFAULT);

// update di database
$stmt = $conn->prepare("UPDATE tb_user SET password=? WHERE email=?");
$stmt->bind_param("ss", $hashed_password, $email_admin);

if($stmt->execute()){
    echo "Password admin sudah di-hash dan tersimpan di database!";
} else {
    echo "Gagal update password: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
