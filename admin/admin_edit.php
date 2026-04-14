<?php
include '../koneksi.php';

/* cek id */
if(!isset($_GET['id'])){
    echo "ID admin tidak ditemukan";
    exit;
}

$id = $_GET['id'];

/* ambil data admin */
$data = mysqli_query($conn,"SELECT * FROM admin WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

/* jika data tidak ada */
if(!$row){
    echo "Data admin tidak ditemukan";
    exit;
}

/* update data */
if(isset($_POST['update'])){

    $username = $_POST['username'];

    if($_POST['password'] != ""){

        $password = md5($_POST['password']);

        mysqli_query($conn,"UPDATE admin SET
        username='$username',
        password='$password'
        WHERE id='$id'");

    }else{

        mysqli_query($conn,"UPDATE admin SET
        username='$username'
        WHERE id='$id'");

    }

    header("Location: admin_index.php");
}
?>

<h2>Edit Admin</h2>

<form method="POST">

Username <br>
<input type="text" name="username"
value="<?= $row['username'] ?>" required>
<br><br>

Password (kosongkan jika tidak diganti) <br>
<input type="password" name="password">
<br><br>

<button type="submit" name="update">Update</button>

</form>