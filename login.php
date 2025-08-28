<?php 
session_start();
include "koneksi.php";

$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = strtolower(trim($user['role'])); // admin atau user

            // Redirect sesuai role
            if($_SESSION['role'] === 'admin'){
                header("Location: dashboard_admin.php");
                exit;
            } elseif($_SESSION['role'] === 'user'){
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Role tidak dikenali!";
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Laundry</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url("WhatsApp Image 2025-08-15 at 13.42.02.jpeg");
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #6a11cb;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            width: 95%;
            padding: 10px;
            background: #6a11cb;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #ff66a3;
        }
        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Laundry</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Masukkan Email" required><br>
            <input type="password" name="password" placeholder="Masukkan Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <div class="footer">
            &copy; <?= date('Y') ?> Laundry App
        </div>
    </div>
</body>
</html>
