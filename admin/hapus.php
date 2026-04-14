<?php
include '../koneksi.php';

$id = $_GET['id'];

// ambil nama gambar
$data = mysqli_query($conn,"SELECT gambar FROM menu WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

// hapus file gambar
if(file_exists("../img/menu/".$row['gambar'])){
    unlink("../img/menu/".$row['gambar']);
}

// hapus data
mysqli_query($conn,"DELETE FROM menu WHERE id='$id'");

header("Location: index.php");
