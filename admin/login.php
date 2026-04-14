<?php
session_start();
include '../koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek username dulu
    $cekUser = mysqli_query($conn, 
        "SELECT * FROM admin WHERE username='$username'"
    );

    if (mysqli_num_rows($cekUser) == 0) {
        // Username tidak ada
        $error = "❌ Username salah";
    } else {
        // Username ada → cek password
        $data = mysqli_fetch_assoc($cekUser);

        if ($password !== $data['password']) {
            $error = "❌ Password salah";
        } else {
            // Login sukses
            $_SESSION['admin'] = $data['username'];
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
*{box-sizing:border-box}

body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#e53935,#ff8a80);
    font-family:Arial, sans-serif;
}

.login-box{
    background:#fff;
    width:360px;
    padding:28px;
    border-radius:18px;
    box-shadow:0 18px 40px rgba(0,0,0,.25);
    text-align:center;
}

.login-box h2{
    margin-bottom:22px;
    color:#e53935;
}

.input{
    width:100%;
    padding:13px;
    margin-bottom:14px;
    border-radius:12px;
    border:1.5px solid #f0b3b0;
    font-size:14px;
}

.input:focus{
    outline:none;
    border-color:#e53935;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:#e53935;
    color:white;
    font-size:15px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#d32f2f;
}

.error{
    background:#fdecea;
    color:#c62828;
    padding:10px;
    border-radius:10px;
    margin-bottom:14px;
    font-size:13px;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>🔐 Login Admin</h2>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" class="input"
               placeholder="Username" required>

        <input type="password" name="password" class="input"
               placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>
