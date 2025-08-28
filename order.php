<?php
session_start();
include "koneksi.php";

// pastikan hanya user login yang bisa akses
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// ambil data pesanan dari tb_cucian
$sql = "SELECT o.id, o.nama_cucian, o.berat, o.harga, o.status, o.tanggal,
               u.nama AS nama_pelanggan, u.email
        FROM tb_cucian o
        JOIN tb_user u ON o.user_id = u.id
        ORDER BY o.id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pesanan Cucian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #4f46e5;
            color: #fff;
        }
        tr:hover {
            background: #f9fafb;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: #fff;
        }
        .btn-delete {
            background: #ef4444;
        }
        .btn-update {
            background: #3b82f6;
        }
    </style>
</head>
<body>
    <h2>Daftar Pes
