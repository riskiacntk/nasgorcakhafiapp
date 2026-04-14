<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM admin WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // TANPA hash

    mysqli_query($conn, "UPDATE admin SET 
        username='$username', 
        password='$password' 
        WHERE id='$id'");

    header("Location: lihat_admin.php");
    exit;
}
?>

<h2>Edit Admin</h2>

<form method="post">
    Username <br>
    <input type="text" name="username" value="<?= $row['username'] ?>" required><br><br>

    Password Baru <br>
    <input type="text" name="password" value="<?= $row['password'] ?>" required><br><br>

    <button type="submit" name="update">Update</button>
</form>
