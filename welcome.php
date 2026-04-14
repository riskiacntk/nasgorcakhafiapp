<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nasi Goreng Cak Hafi</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

body{
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(rgba(229,57,53,.65), rgba(198,40,40,.65)),
    url('assets/img/nasi goreng.images.jpg');
    background-size:cover;
    background-position:center;
    text-align:center;
    color:white;
}

.container{
    max-width:750px;
    padding:45px 35px;
    background:rgba(255,255,255,0.12);
    backdrop-filter: blur(8px);
    border-radius:25px;
    box-shadow:0 10px 35px rgba(229,57,53,0.4);
}

/* Tulisan atas */
.subtitle{
    font-size:22px;
    letter-spacing:2px;
    margin-bottom:10px;
    font-weight:500;
    opacity:0.95;
}

/* Tulisan besar */
.title{
    font-size:52px;
    font-weight:bold;
    margin-bottom:20px;
    color:#fff;
    text-shadow:2px 4px 12px rgba(0,0,0,0.4);
}

/* Deskripsi */
p{
    font-size:18px;
    margin-bottom:35px;
    line-height:1.6;
    opacity:0.95;
}

/* Tombol */
.btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:65px;
    height:65px;
    font-size:28px;
    background:linear-gradient(135deg, #ff8a65, #e53935);
    color:white;
    border-radius:50%;
    text-decoration:none;
    transition:0.3s ease;
    box-shadow:0 6px 20px rgba(0,0,0,0.3);
}

.btn:hover{
    transform:scale(1.12);
    background:linear-gradient(135deg, #ff7043, #c62828);
}
</style>
</head>

<body>

<div class="container">

    <div class="subtitle">Selamat Datang di</div>

    <div class="title">Nasi Goreng Cak Hafi</div>

    <p>
        ayo makan menu makanan dan minuman enak murah meriah hanya di sini,
        penasaran kan sama rasanya? yuk kepoin dan pesan sekarang juga
    </p>

    <a href="index.php" class="btn">→</a>

</div>

</body>
</html>
