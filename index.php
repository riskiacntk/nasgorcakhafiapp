<?php
session_start();

/* ===== JUMLAH KERANJANG ===== */
$jumlahKeranjang = 0;
if (!empty($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $jumlahKeranjang += $item['qty'];
    }
}

include 'koneksi.php';

/* ===== STATUS TOKO ===== */
$qStatus = mysqli_query($conn, "SELECT * FROM status_toko WHERE id = 1");
$statusToko = mysqli_fetch_assoc($qStatus);

/* ===== QUERY KATEGORI (FIX ERROR DI SINI) ===== */
$makanan = mysqli_query($conn, "SELECT * FROM menu WHERE LOWER(kategori)='makanan'");
$minuman = mysqli_query($conn, "SELECT * FROM menu WHERE LOWER(kategori)='minuman'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Menu Nasi Goreng</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">

<style>
*{box-sizing:border-box;font-family:Arial,sans-serif}
body{margin:0;background:#f5f5f5}

/* NAVBAR */
.navbar{display:flex;justify-content:space-between;align-items:center;background:#fff;padding:10px 14px;box-shadow:0 2px 6px rgba(0,0,0,.1);position:sticky;top:0;z-index:20}
.nav-left{display:flex;align-items:center;gap:8px}
.logo{width:36px;height:36px;object-fit:contain}
.brand{font-size:15px;font-weight:bold;font-family:"Bungee",sans-serif}
.nav-right{display:flex;align-items:center;gap:14px}
.nav-link{text-decoration:none;color:#333;font-size:14px}
.cart-btn{position:relative;background:#e53935;color:#fff;padding:6px 10px;border-radius:6px;font-size:13px;font-weight:bold;text-decoration:none}
.cart-badge{position:absolute;top:-6px;right:-6px;background:#ffeb3b;color:#000;font-size:11px;padding:2px 6px;border-radius:50%}

/* MENU */
.menu-wrapper{max-width:1100px;margin:auto}
.menu-list{padding:16px;display:grid;grid-template-columns:repeat(auto-fill,180px);gap:16px;justify-content:center}
.menu-item{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,.08)}
.menu-item img{width:100%;height:120px;object-fit:cover}
.menu-info{padding:10px}
.menu-info h4{margin:0;font-size:14px}
.price{margin-top:6px;color:#e53935;font-weight:bold;font-size:13px}
.stok{font-size:12px;color:#666;margin-top:4px}
.btn-beli{width:100%;background:#e53935;color:#fff;border:none;padding:8px;font-size:13px;cursor:pointer}
.btn-beli:disabled{background:#aaa}

/* FOOTER */
.footer{background:linear-gradient(135deg,#8b1d1d,#5a0f0f);color:#fff;margin-top:40px}
.footer-container{max-width:1100px;margin:auto;padding:30px 16px;display:grid;gap:20px}
.footer-bottom{text-align:center;padding:12px}
</style>
</head>

<body>

<header class="navbar">
    <div class="nav-left">
        <img src="img/logonasgor.avif" class="logo">
        <span class="brand">Nasi Goreng Cak Hafi</span>
    </div>

    <div class="nav-right">
        <a href="keranjang.php" class="cart-btn">🛒
            <?php if ($jumlahKeranjang > 0) { ?>
                <span class="cart-badge"><?= $jumlahKeranjang ?></span>
            <?php } ?>
        </a>
        <a href="tentang.php" class="nav-link">Tentang Kami</a>
        <a href="admin/login.php" class="nav-link">Login</a>
    </div>
</header>

<?php if ($statusToko['status'] == 'tutup') { ?>
<div style="background:#ffebee;padding:10px;text-align:center">
    TOKO SEDANG TUTUP
</div>
<?php } ?>

<div class="menu-wrapper">

<!-- ===== MAKANAN ===== -->
<h3 style="padding:10px 16px">🍛 Makanan</h3>
<div class="menu-list">

<?php while ($row = mysqli_fetch_assoc($makanan)) { ?>
<div class="menu-item">

<img src="img/menu/<?= $row['gambar'] ?>">

<div class="menu-info">
<h4><?= $row['nama_menu'] ?></h4>
<div class="price">Rp <?= number_format($row['harga'],0,',','.') ?></div>

<?php
$stok = $row['jumlah'];
if (!empty($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        if ($item['id'] == $row['id']) {
            $stok -= $item['qty'];
        }
    }
}
if ($stok < 0) $stok = 0;
?>
<div class="stok">Stok: <?= $stok ?></div>
</div>

<?php if ($stok > 0) { ?>
<form action="tambah_keranjang.php" method="POST">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<button class="btn-beli">Masukkan Keranjang</button>
</form>
<?php } else { ?>
<button class="btn-beli" disabled>HABIS</button>
<?php } ?>

</div>
<?php } ?>

</div>


<!-- ===== MINUMAN ===== -->
<h3 style="padding:10px 16px">🥤 Minuman</h3>
<div class="menu-list">

<?php while ($row = mysqli_fetch_assoc($minuman)) { ?>
<div class="menu-item">

<img src="img/menu/<?= $row['gambar'] ?>">

<div class="menu-info">
<h4><?= $row['nama_menu'] ?></h4>
<div class="price">Rp <?= number_format($row['harga'],0,',','.') ?></div>

<?php
$stok = $row['jumlah'];
if (!empty($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        if ($item['id'] == $row['id']) {
            $stok -= $item['qty'];
        }
    }
}
if ($stok < 0) $stok = 0;
?>
<div class="stok">Stok: <?= $stok ?></div>
</div>

<?php if ($stok > 0) { ?>
<form action="tambah_keranjang.php" method="POST">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<button class="btn-beli">Masukkan Keranjang</button>
</form>
<?php } else { ?>
<button class="btn-beli" disabled>HABIS</button>
<?php } ?>

</div>
<?php } ?>

</div>

</div>

<footer class="footer">
    <div class="footer-container">
        <div>
            <h4>Nasi Goreng Cak Hafi</h4>
            <p>Murah tapi tidak murahan</p>
        </div>
    </div>
    <div class="footer-bottom">
        © <?= date('Y') ?>
    </div>
</footer>

</body>
</html>