<?php
include '../koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Menu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{
    font-family:Arial,sans-serif;
    background:#fff5f5;
    padding:24px;
    color:#333;
}

/* JUDUL */
.page-title{
    color:#e53935;
    margin-bottom:10px;
}

/* TOMBOL TAMBAH */
.btn-add{
    display:inline-block;
    background:#e53935;
    color:#fff;
    padding:10px 18px;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
    margin-bottom:20px;
}

.action{
    display: flex;
    justify-content: flex-end;
}

/* GRID */
.menu-admin-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
    gap:20px;
}

/* CARD */
.menu-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 22px rgba(229,57,53,.15);
    transition:.25s;
}

.menu-card:hover{
    transform:translateY(-4px);
}

/* GAMBAR */
.menu-img{
    width:100%;
    height:160px;
    object-fit:cover;
}

/* BODY */
.menu-body{
    padding:14px;
}

.menu-body h4{
    margin:0;
    color:#c62828;
}

.kategori{
    font-size:13px;
    color:#777;
    margin:4px 0 10px;
}

/* INFO */
.info{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    margin-bottom:12px;
}

/* AKSI */
.aksi{
    display:flex;
    gap:10px;
}

.btn-edit{
    flex:1;
    text-align:center;
    padding:8px;
    border-radius:10px;
    background: #ffcc80;
    color:#5d4037;
    text-decoration:none;
    font-weight:bold;
}

.btn-hapus{
    flex:1;
    text-align:center;
    padding:8px;
    border-radius:10px;
    background: #ef5350;
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}
.btn-stok{
    flex:1;
    text-align:center;
    padding:8px;
    border-radius:10px;
    background: #66bb6a;
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}
.menu-wrapper{
    position:relative;
}

.menu-btn{
    font-size:24px;
    background:none;
    border:none;
    cursor:pointer;
}

.menu-dropdown{
    display:none;
    position:absolute;
    top:35px;
    right:0;
    background:#fff;
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
    border-radius:8px;
    overflow:hidden;
    min-width:160px;
    z-index:999;
}

.menu-dropdown a{
    display:block;
    padding:10px;
    text-decoration:none;
    color:#333;
}

.menu-dropdown a:hover{
    background:#f2f2f2;
}
.menu-dropdown a{
display:flex;
align-items:center;
gap:8px;
padding:10px 14px;
text-decoration:none;
color:#333;
font-size:14px;
}

.menu-dropdown a:hover{
background:#f2f2f2;
}

</style>
</head>

<body>

<h2 class="page-title">📋 Data Menu</h2>

<div class="action">
<a href="tambah.php" class="btn-add">➕ Tambah Menu</a>
</div>


<!-- MENU TITIK TIGA -->
<div class="menu-wrapper" style="position:absolute; top:20px; right:20px;">

    <div class="menu-wrapper">

        <button class="menu-btn" onclick="toggleMenu()">⋮</button>

      <div class="menu-dropdown" id="menuDropdown">



<a href="status_toko.php">🟢 Status Toko</a>

<a href="logout.php">🚪 Logout</a>

</div>

    </div>

</div>



<div class="menu-admin-grid">

<?php while($row = mysqli_fetch_assoc($data)) { ?>
    <div class="menu-card">
        <img src="../img/menu/<?= $row['gambar'] ?>"
             class="menu-img"
             onerror="this.src='../img/no-image.png'">

        <div class="menu-body">
            <h4><?= htmlspecialchars($row['nama_menu']) ?></h4>
            <p class="kategori"><?= ucfirst($row['kategori']) ?></p>

            <div class="info">
                <span>💰 Rp <?= number_format($row['harga'],0,',','.') ?></span>
                <span>📦 Stok: <?= $row['jumlah'] ?></span>
            </div>

            <div class="aksi">
    <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
    <a href="tambah_stok.php?id=<?= $row['id'] ?>" class="btn-stok">+ Stok</a>
    <a href="hapus.php?id=<?= $row['id'] ?>"
       class="btn-hapus"
       onclick="return confirm('Hapus menu ini?')">
       Hapus
    </a>
</div>
        </div>
    </div>
<?php } ?>

</div>
<script>

function toggleMenu(){

var menu = document.getElementById("menuDropdown");

if(menu.style.display === "block"){
menu.style.display = "none";
}else{
menu.style.display = "block";
}

}

/* klik di luar menu = menu tertutup */
window.onclick = function(event){
if(!event.target.matches('.menu-btn')){
var dropdown = document.getElementById("menuDropdown");
if(dropdown.style.display === "block"){
dropdown.style.display = "none";
}
}
}

</script>
</body>
</html>
