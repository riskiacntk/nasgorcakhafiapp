<?php
session_start();

/* ================= CEK KERANJANG ================= */
if (empty($_SESSION['keranjang'])) {
    die('Keranjang kosong');
}

/* ================= AMBIL DATA FORM ================= */
$nama       = trim($_POST['nama'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');
$catatan    = trim($_POST['catatan'] ?? '');
$pembayaran = $_POST['pembayaran'] ?? '';

if ($nama === '' || $alamat === '' || $pembayaran === '') {
    die('Data tidak lengkap');
}

/* ================= SUSUN PESAN WHATSAPP ================= */
$pesan  = " *PESANAN BARU*\n\n";
$pesan .= " Nama: $nama\n";
$pesan .= " Alamat: $alamat\n";
$pesan .= " Pembayaran: $pembayaran\n";

if ($pembayaran === 'DANA') {
    $pesan .= " Bukti Pembayaran: Jika sudah memesan lewat metode pembayaran DANA, kirim ss tf manual di sini.\n";
}

$pesan .= "\n *DETAIL PESANAN*\n";

$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $sub = $item['qty'] * $item['harga'];
    $total += $sub;

    $pesan .= "- {$item['nama']} ({$item['qty']} x "
            . number_format($item['harga'], 0, ',', '.')
            . ") = Rp "
            . number_format($sub, 0, ',', '.')
            . "\n";
}

$pesan .= "\n *Total*: Rp " . number_format($total, 0, ',', '.');

if ($catatan !== '') {
    $pesan .= "\n Catatan: $catatan";
}

/* ================= KIRIM KE WHATSAPP ================= */
$no_wa = '6283853349892'; // GANTI NO WA KAMU
$url   = "https://wa.me/$no_wa?text=" . urlencode($pesan);

/* ================= BERSIHKAN SESSION ================= */
unset(
    $_SESSION['keranjang'],
    $_SESSION['nama'],
    $_SESSION['alamat'],
    $_SESSION['catatan'],
    $_SESSION['pembayaran']
);

header("Location: $url");
exit;
