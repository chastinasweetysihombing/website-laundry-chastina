<?php
include "db_laundry.php";

// Data user baru
$username = "admin"; // bisa diganti
$email = "chastinasweety@gmail.com"; // bisa diganti
$password_plain = "12345"; // password asli
$role = "user"; // bisa 'admin' atau 'user'

// Hash password sebelum disimpan
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Cek apakah email sudah ada
$cek = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE email='$email'");
if(mysqli_num_rows($cek) > 0){
    echo "User dengan email $email sudah ada!";
} else {
    // Masukkan ke database
    $query = "INSERT INTO tb_user (username, email, password, role) 
              VALUES ('$username','$email','$password_hashed','$role')";
    if(mysqli_query($koneksi, $query)){
        echo "User baru berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan user: " . mysqli_error($koneksi);
    }
}
?>
