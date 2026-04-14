<?php
include 'koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM admin");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Admin</title>
</head>
<body>

<h2>Data Admin</h2>
<a href="tambah_admin.php">+ Tambah Admin</a>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($row = mysqli_fetch_assoc($data)) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['username'] ?></td>
        <td>
            <a href="edit_admin.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
