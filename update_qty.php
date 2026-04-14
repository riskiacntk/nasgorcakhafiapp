<?php
session_start();

$id   = $_GET['id'];
$aksi = $_GET['aksi'];

if (!isset($_SESSION['keranjang'][$id])) {
    header("Location: keranjang.php");
    exit;
}

if ($aksi == 'tambah') {
    $_SESSION['keranjang'][$id]['qty'] += 1;
}

if ($aksi == 'kurang') {
    $_SESSION['keranjang'][$id]['qty'] -= 1;

    // Kalau qty 0, hapus menu
    if ($_SESSION['keranjang'][$id]['qty'] <= 0) {
        unset($_SESSION['keranjang'][$id]);
    }
}

header("Location: keranjang.php");
exit;
