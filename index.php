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

/* ===== FILTER ===== */
$keyword  = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

$where = [];
if ($keyword != '') {
    $where[] = "nama_menu LIKE '%$keyword%'";
}
if ($kategori != '') {
    $where[] = "kategori = '$kategori'";
}

$where_sql = "WHERE gambar IS NOT NULL AND gambar != ''";
if (!empty($where)) {
    $where_sql .= " AND " . implode(" AND ", $where);
}

$query = "SELECT * FROM menu $where_sql";
$menu = mysqli_query($conn, $query);
if (!$menu) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Menu Nasi Goreng</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

/* SEARCH */
.header{background:#fff;padding:12px}
.search-wrapper{max-width:1100px;margin:auto}
.search-form{display:flex;gap:10px}
.search-form input,.search-form select{padding:10px;border-radius:8px;border:1px solid #ddd}
.search-form input{flex:3}
.search-form select{flex:1}
.search-form button{padding:10px 16px;border-radius:8px;border:none;background:#e53935;color:#fff}

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
.btn-beli:disabled{background:#aaa;cursor:not-allowed}

/* PENGUMUMAN */
.pengumuman-tutup{background:#ffebee;color:#b71c1c;border:1px solid #ffcdd2;padding:14px;margin:12px auto;max-width:1100px;border-radius:10px;text-align:center;font-size:14px;font-weight:bold}

/* FOOTER */
.footer{background:linear-gradient(135deg,#8b1d1d,#5a0f0f);color:#fff;margin-top:40px}
.footer-container{
    max-width:1100px;
    margin:auto;
    padding:30px 16px;
    display:grid;
    grid-template-columns: 1fr; /* MOBILE default */
    gap:20px;
}

.footer-box h4{margin:4px 0;font-size:15px}
.footer-box p{margin:4px 0;font-size:13px;color:#f0f0f0}
.footer-bottom{border-top:1px solid rgba(255,255,255,.2);padding:12px;text-align:center;font-size:13px}


/* MOBILE */
@media (min-width: 768px){
    .footer-container{
        grid-template-columns: repeat(3, 1fr);
    }
}
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
<div class="pengumuman-tutup">
    🚨 <strong>TOKO SEDANG TUTUP</strong><br>
    <?= htmlspecialchars($statusToko['alasan']) ?>
</div>
<?php } ?>

<div class="menu-wrapper">
<div class="menu-list">

<?php while ($row = mysqli_fetch_assoc($menu)) { ?>
<div class="menu-item">

    <img src="img/menu/<?= $row['gambar'] ?>" onerror="this.src='img/no-image.png'">

    <div class="menu-info">
        <h4><?= $row['nama_menu'] ?></h4>
        <div class="price">Rp <?= number_format($row['harga'],0,',','.') ?></div>
        <div class="stok">Stok: <?= $row['jumlah'] ?></div>
    </div>

    <?php if ($statusToko['status'] == 'tutup') { ?>
        <button class="btn-beli" disabled>TOKO TUTUP</button>

    <?php } elseif ($row['jumlah'] > 0) { ?>
        <form action="tambah_keranjang.php" method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button type="submit" class="btn-beli">Masukkan Keranjang</button>
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
        <div class="footer-box">
            <h4>Nasi Goreng Cak Hafi</h4>
            <p>Nikmati menu dan minuman enak hanya di sini, harga murah tapi rasa tidak murahan</p>
        </div>
<div class="footer-box jam-buka">
    <h4>Jam Buka</h4>
    <p>Jumat-Rabu</p>
    <p>17.30 – 23.00</p>
</div>

        <div class="footer-box">
            <h4>Alamat</h4>
            <p>Jl. Dumajeh barat, depan masjid baiturrahman, kec.tanah merah kab.bangkalan, 69172</p>
        </div>
    </div>

    <div class="footer-bottom">
        © <?= date('Y') ?> Nasi Goreng Cak Hafi bapak kia. All rights reserved.
    </div>
</footer>

</body>
</html>
