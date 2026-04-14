<?php
session_start();

/* hapus semua session login */
session_destroy();

/* kembali ke halaman utama menu */
header("Location: ../index.php");
exit;
?>