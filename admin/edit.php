<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $nama     = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga    = (int) $_POST['harga'];
    $jumlah   = (int) $_POST['jumlah'];

    $gambar = time() . '_' . $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];
    $path   = "../img/menu/" . $gambar;

    if (move_uploaded_file($tmp, $path)) {
        mysqli_query($conn, "INSERT INTO menu 
        (nama_menu,kategori,harga,gambar,jumlah)
        VALUES ('$nama','$kategori','$harga','$gambar','$jumlah')");

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Menu</title>
</head>

<body style="background:#fff5f5 !important;
             font-family:Arial !important;
             padding:24px !important;">

<div style="
max-width:460px;
margin:auto;
background:#fff;
border-radius:20px;
padding:24px;
box-shadow:0 12px 28px rgba(229,57,53,.25);">

<h2 style="text-align:center;color:#e53935;">➕ Tambah Menu</h2>

<form method="post" enctype="multipart/form-data">

<label style="font-weight:bold;color:#c62828;">Nama Menu</label>
<input type="text" name="nama_menu" required
style="width:100%;padding:12px;border-radius:12px;border:1.5px solid #f0b3b0;margin-bottom:14px;">

<label style="font-weight:bold;color:#c62828;">Kategori</label>
<select name="kategori" required
style="width:100%;padding:12px;border-radius:12px;border:1.5px solid #f0b3b0;margin-bottom:14px;">
    <option value="">-- Pilih --</option>
    <option value="makanan">Makanan</option>
    <option value="minuman">Minuman</option>
</select>

<label style="font-weight:bold;color:#c62828;">Harga</label>
<input type="number" name="harga" required
style="width:100%;padding:12px;border-radius:12px;border:1.5px solid #f0b3b0;margin-bottom:14px;">

<label style="font-weight:bold;color:#c62828;">Stok</label>
<input type="number" name="jumlah" required
style="width:100%;padding:12px;border-radius:12px;border:1.5px solid #f0b3b0;margin-bottom:14px;">

<label style="font-weight:bold;color:#c62828;">Gambar</label>
<input type="file" name="gambar" required
style="width:100%;margin-bottom:18px;">

<button type="submit" name="simpan"
style="
width:100%;
padding:14px;
border:none;
border-radius:16px;
background:#e53935;
color:#fff;
font-weight:bold;
font-size:15px;
cursor:pointer;">
💾 Simpan Menu
</button>

</form>

<a href="index.php"
style="display:block;text-align:center;margin-top:14px;color:#e53935;font-weight:bold;">
← Kembali
</a>

</div>

</body>
</html>
