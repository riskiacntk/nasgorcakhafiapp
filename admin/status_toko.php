<?php
session_start();
include '../koneksi.php';

/* ===== STATUS TOKO ===== */
$dataStatus = mysqli_query($conn, "SELECT * FROM status_toko WHERE id = 1");
$statusToko = mysqli_fetch_assoc($dataStatus);

/* simpan perubahan */
if (isset($_POST['simpan'])) {
    $status = $_POST['status'];
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan']);

    mysqli_query($conn, "
        UPDATE status_toko 
        SET status='$status', alasan='$alasan'
        WHERE id=1
    ");
}

/* AMBIL STATUS TOKO */
$data = mysqli_query($conn, "SELECT * FROM status_toko WHERE id = 1");
$toko = mysqli_fetch_assoc($data);

/* ICON OTOMATIS */
$icon = ($toko['status'] == 'buka') ? '🔓' : '🔒';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Status Toko</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">

<style>
* {
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    margin: 0;
    min-height: 100vh;
    padding: 40px 16px;
    background: linear-gradient(135deg, #e53935, #c62828);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===== CARD ===== */
.card {
    width: 100%;
    max-width: 500px;
    background: #ffffff;
    border-radius: 22px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    overflow: hidden;
}

/* ===== HEADER ===== */
.card-header {
    background: linear-gradient(135deg, #ff7043, #e53935);
    color: #fff;
    padding: 22px;
    text-align: center;
}

.card-header h2 {
    margin: 0;
    font-family: "Bungee", sans-serif;
    font-size: 20px;
    letter-spacing: 1px;
}

/* ===== BODY ===== */
.card-body {
    padding: 25px;
}

/* ===== STATUS BADGE ===== */
.status-box {
    display: flex;
    justify-content: center;
    margin-bottom: 22px;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    border-radius: 30px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    letter-spacing: 1px;
}

/* WARNA DINAMIS */
.status-buka {
    background: linear-gradient(135deg, #43a047, #2e7d32);
    box-shadow: 0 5px 15px rgba(46,125,50,0.4);
}

.status-tutup {
    background: linear-gradient(135deg, #ef5350, #c62828);
    box-shadow: 0 5px 15px rgba(198,40,40,0.4);
}

/* ===== FORM ===== */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #444;
}

select, textarea {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ddd;
    font-size: 14px;
    transition: 0.3s;
}

select:focus,
textarea:focus {
    outline: none;
    border-color: #e53935;
    box-shadow: 0 0 0 3px rgba(229,57,53,0.15);
}

textarea {
    min-height: 100px;
    resize: vertical;
}

/* BUTTON */
.btn-simpan {
    width: 100%;
    background: linear-gradient(135deg, #ff7043, #e53935);
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 14px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}

.btn-simpan:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(229,57,53,0.4);
}
</style>
</head>

<body>

<div class="card">

    <div class="card-header">
        <h2>Pengaturan Status Toko</h2>
    </div>

    <div class="card-body">

        <!-- STATUS -->
        <div class="status-box">
            <div class="status-badge <?php echo ($toko['status'] == 'buka') ? 'status-buka' : 'status-tutup'; ?>">
                <?php echo $icon; ?>
                <?php echo strtoupper($toko['status']); ?>
            </div>
        </div>

        <form method="POST">

            <div class="form-group">
                <label>Status Toko</label>
                <select name="status">
                    <option value="buka" <?php if($toko['status']=='buka') echo 'selected'; ?>>
                        Buka
                    </option>
                    <option value="tutup" <?php if($toko['status']=='tutup') echo 'selected'; ?>>
                        Tutup
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Alasan (jika toko tutup)</label>
                <textarea name="alasan"><?php echo $toko['alasan']; ?></textarea>
            </div>

            <button type="submit" name="simpan" class="btn-simpan">
                Simpan Perubahan
            </button>

        </form>

    </div>
</div>

</body>
</html>
