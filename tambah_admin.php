<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    mysqli_query($conn, "INSERT INTO admin VALUES('', '$username', '$password')");
    header("Location: lihat_admin.php");
}
?>

<h2>Tambah Admin</h2>

<form method="post">
    Username <br>
    <input type="text" name="username" required><br><br>

    Password <br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>
