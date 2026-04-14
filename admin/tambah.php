<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $nama     = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga    = (int) $_POST['harga'];
    $jumlah   = (int) $_POST['jumlah'];

    // Upload gambar
    $gambar = time() . '_' . $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];
    $path   = "../img/menu/" . $gambar;

    if (move_uploaded_file($tmp, $path)) {

        $query = "INSERT INTO menu 
            (nama_menu, kategori, harga, gambar, jumlah)
            VALUES 
            ('$nama', '$kategori', '$harga', '$gambar', '$jumlah')";

        mysqli_query($conn, $query);

        header("Location: index.php");
        exit;

    } else {
        echo "Upload gambar gagal!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg, #e53935, #c62828);
}

/* Card Form */
.form-container{
    width:100%;
    max-width:450px;
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#e53935;
}

/* Label */
label{
    font-weight:600;
    font-size:14px;
    display:block;
    margin-bottom:6px;
    color:#444;
}

/* Input & Select */
input[type="text"],
input[type="number"],
select,
input[type="file"]{
    width:100%;
    padding:10px 12px;
    border:1px solid #ddd;
    border-radius:8px;
    margin-bottom:18px;
    font-size:14px;
    transition:0.3s;
}

input:focus,
select:focus{
    border-color:#e53935;
    outline:none;
    box-shadow:0 0 0 3px rgba(229,57,53,0.15);
}

/* Button */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#ff7043,#e53935);
    color:white;
    font-size:15px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(229,57,53,0.4);
}

/* Responsive */
@media(max-width:480px){
    .form-container{
        margin:20px;
        padding:25px;
    }
}
</style>

</head>
<body>

<div class="form-container">

<h2>Tambah Menu</h2>

<form method="post" enctype="multipart/form-data">

    <label>Nama Menu</label>
    <input type="text" name="nama_menu" required>

    <label>Kategori</label>
    <select name="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="makanan">Makanan</option>
        <option value="minuman">Minuman</option>
    </select>

    <label>Harga</label>
    <input type="number" name="harga" required>

    <label>Stok</label>
    <input type="number" name="jumlah" required>

    <label>Gambar</label>
    <input type="file" name="gambar" accept="image/*" required>

    <button type="submit" name="simpan">Simpan Menu</button>

</form>

</div>

</body>
</html>
