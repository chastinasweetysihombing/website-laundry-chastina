<?php
include "koneksi.php"; // koneksi ke database

// ambil semua user
$result = $conn->query("SELECT id, password FROM tb_user");

if($result->num_rows > 0){
    while($user = $result->fetch_assoc()){
        $id = $user['id'];
        $password = $user['password'];

        // cek apakah password sudah hash (bcrypt biasanya mulai dengan $2y$)
        if(strpos($password, '$2y$') !== 0){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // update password di database
            $stmt = $conn->prepare("UPDATE tb_user SET password=? WHERE id=?");
            $stmt->bind_param("si", $hashed_password, $id);
            $stmt->execute();
            $stmt->close();

            echo "Password user ID $id sudah di-hash.<br>";
        } else {
            echo "Password user ID $id sudah hash.<br>";
        }
    }
} else {
    echo "Tidak ada user ditemukan.";
}

$conn->close();
?>
