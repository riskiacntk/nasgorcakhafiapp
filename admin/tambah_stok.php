<?php
include '../koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM menu WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['tambah'])){
    $tambah = (int) $_POST['jumlah'];

    mysqli_query($conn, "
        UPDATE menu 
        SET jumlah = jumlah + $tambah 
        WHERE id='$id'
    ");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Stok</title>
<style>
body{
    font-family:Arial;
    background:#fff5f5;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    background:#fff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 22px rgba(229,57,53,.2);
    width:320px;
    text-align:center;
}

h2{
    color:#e53935;
}

input{
    width:100%;
    padding:10px;
    border-radius:10px;
    border:1px solid #ddd;
    margin-top:10px;
}

button{
    margin-top:15px;
    width:100%;
    padding:10px;
    border:none;
    border-radius:12px;
    background:#66bb6a;
    color:white;
    font-weight:bold;
    cursor:pointer;
}
</style>
</head>
<body>

<div class="card">
    <h2>Tambah Stok</h2>
    <p><b><?= $row['nama_menu'] ?></b></p>
    <p>Stok Sekarang: <?= $row['jumlah'] ?></p>

    <form method="post">
        <input type="number" name="jumlah" placeholder="Masukkan jumlah tambahan" required>
        <button type="submit" name="tambah">Tambah Stok</button>
    </form>
</div>

</body>
</html>
