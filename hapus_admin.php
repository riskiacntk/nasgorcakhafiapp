<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM admin WHERE id='$id'");

header("Location: lihat_admin.php");
?>
