<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "nasgor_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("koneksi database salah" . mysqli_connect_error());
}