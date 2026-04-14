<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['keranjang'][$id])) {
        if ($_SESSION['keranjang'][$id]['qty'] > 1) {
            $_SESSION['keranjang'][$id]['qty']--;
        } else {
            unset($_SESSION['keranjang'][$id]);
        }
    }
}

header("Location: keranjang.php");
exit;
