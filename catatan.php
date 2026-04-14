<?php
include 'koneksi.php';

if (!isset($_GET['id']) || !isset($_GET['qty'])) {
    die("Data tidak lengkap");
}

$id  = (int) $_GET['id'];
$qty = (int) $_GET['qty'];

$menu = mysqli_query($conn, "SELECT * FROM menu WHERE id = $id");
$data = mysqli_fetch_assoc($menu);

if (!$data) {
    die("Menu tidak ditemukan");
}

$total = $data['harga'] * $qty;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Catatan Pesanan</title>
<style>
body { font-family: Arial; background:#f5f5f5; padding:15px; }
.box {
    max-width:420px; margin:auto; background:#fff;
    padding:15px; border-radius:12px;
}
.row { margin-bottom:6px; font-size:14px; }
textarea {
    width:100%; padding:10px; border-radius:8px;
    border:1px solid #ccc; resize:none;
}
button {
    background:#25D366; color:#fff; border:none;
    padding:12px; width:100%; border-radius:8px;
    margin-top:10px; cursor:pointer;
}
</style>
</head>
<body>

<div class="box">
    <h3>Catatan Pesanan</h3>

    <!-- RINCIAN PESANAN (RAPI) -->
    <div class="row"><b>Menu:</b> <?= htmlspecialchars($data['nama_menu']); ?></div>
    <div class="row"><b>Harga:</b> Rp <?= number_format($data['harga'],0,',','.'); ?></div>
    <div class="row"><b>Jumlah:</b> <?= $qty; ?></div>
    <div class="row"><b>Total:</b> Rp <?= number_format($total,0,',','.'); ?></div>

    <hr>

    <!-- CATATAN KOSONG -->
    <form action="kirim_wa.php" method="post">
        <textarea name="catatan" rows="4" placeholder="Tulis catatan (opsional)..."></textarea>

        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="qty" value="<?= $qty ?>">

        <button type="submit">Kirim ke WhatsApp</button>
    </form>
</div>

</body>
</html>
