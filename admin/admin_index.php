<?php
include '../koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM admin");
?>

<h2>Data Admin</h2>

<a href="admin_tambah.php">+ Tambah Admin</a><br><br>

<table border="1" cellpadding="10">
<tr>
    <th>No</th>
    <th>Username</th>
    <th>Aksi</th>
</tr>

<?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['username'] ?></td>
    <td>
        <a href="admin_edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="admin_hapus.php?id=<?= $row['id'] ?>"
        onclick="return confirm('Yakin hapus admin ini?')">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>