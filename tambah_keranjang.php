<?php
session_start();
include 'koneksi.php';

$id = (int) $_POST['id'];

/* Ambil data menu */
$q = mysqli_query($conn, "SELECT * FROM menu WHERE id = $id");
$menu = mysqli_fetch_assoc($q);

if (!$menu) {
    header("Location: index.php");
    exit;
}

/* Cek stok */
if ($menu['jumlah'] <= 0) {
    header("Location: index.php");
    exit;
}

/* Keranjang session */
if (!isset($_SESSION['keranjang'][$id])) {
    $_SESSION['keranjang'][$id] = [
        'id'    => $menu['id'],
        'nama'  => $menu['nama_menu'],
        'harga' => $menu['harga'],
        'qty'   => 1
    ];
} else {
    $_SESSION['keranjang'][$id]['qty'] += 1;
}

/* Kurangi stok di database */
mysqli_query($conn, "
    UPDATE menu 
    SET jumlah = jumlah - 1 
    WHERE id = $id
");

/* Kembali ke halaman utama */
header("Location: index.php");
exit;
