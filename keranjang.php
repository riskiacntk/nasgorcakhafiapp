<?php
session_start();

/* ================= UPDATE QTY (AJAX) ================= */
if(isset($_POST['aksi']) && isset($_POST['index'])){

$i=$_POST['index'];

if(isset($_SESSION['keranjang'][$i])){

if($_POST['aksi']=="tambah"){
$_SESSION['keranjang'][$i]['qty']++;
}

if($_POST['aksi']=="kurang"){
$_SESSION['keranjang'][$i]['qty']--;

if($_SESSION['keranjang'][$i]['qty']<=0){
unset($_SESSION['keranjang'][$i]);
}
}

}

$total=0;

foreach($_SESSION['keranjang'] as $item){
$total+=$item['qty']*(float)$item['harga'];
}

$ongkir=(($_SESSION['metode']??'')=="Diantar")?1000:0;

$grandTotal=$total+$ongkir;

echo json_encode([
"keranjang"=>$_SESSION['keranjang'],
"total"=>$total,
"ongkir"=>$ongkir,
"grandTotal"=>$grandTotal
]);

exit;
}


/* ================= UPDATE METODE ================= */

if(isset($_POST['metode'])){
$_SESSION['metode']=$_POST['metode'];
exit;
}

if(isset($_POST['pembayaran'])){
$_SESSION['pembayaran']=$_POST['pembayaran'];
exit;
}


if(empty($_SESSION['keranjang'])){
echo "Keranjang kosong";
exit;
}


$total=0;

foreach($_SESSION['keranjang'] as $item){
$total+=$item['qty']*(float)$item['harga'];
}

$ongkir=(($_SESSION['metode']??'')=="Diantar")?1000:0;

$grandTotal=$total+$ongkir;

$noDana="083853349892";
$namaDana="Farihatur rizkiyah";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang</title>

<style>

body{
font-family:Arial, sans-serif;
background:#fff5f5;
padding:1rem;
margin:0;
line-height:1.5;
}

.wrapper{
max-width:1200px;
width:95%;
margin:0 auto;
}

.box{
background:#fff;
border-radius:20px;
padding:25px;
box-shadow:0 10px 30px rgba(0,0,0,.1);
margin-bottom:20px
}

table{
width:100%;
border-collapse:collapse
}

th{
background:#fdeaea;
padding:10px
}

td{
padding:10px;
text-align:center;
border-bottom:1px solid #eee
}

.qty-box{
display:flex;
justify-content:center;
align-items:center;
gap:10px
}

.qty-box button{
background:#e53935;
color:#fff;
border:none;
padding:5px 12px;
border-radius:6px;
cursor:pointer
}

.opsi-box{
display:block;
border:2px solid #ddd;
padding:10px;
border-radius:12px;
margin-bottom:10px;
cursor:pointer
}

.dana-box{
background:#e3f2fd;
padding:15px;
border-radius:12px;
margin-top:10px
}

.kirim{
width:100%;
padding:16px;
background:#e53935;
color:#fff;
border:none;
border-radius:20px;
font-weight:bold;
margin-top:15px;
cursor:pointer
}

</style>
</head>

<body>

<div class="wrapper">

<div class="box">

<h3>Rincian Pesanan</h3>

<table>

<tr>
<th>Menu</th>
<th>Qty</th>
<th>Harga</th>
<th>Total</th>
</tr>

<?php foreach($_SESSION['keranjang'] as $key=>$item):

$sub=$item['qty']*(float)$item['harga'];

?>

<tr>

<td><?=htmlspecialchars($item['nama'])?></td>

<td>

<div class="qty-box">

<button type="button"
onclick="updateQty(<?= $key ?>,'kurang')">-</button>

<b id="qty<?= $key ?>"><?= $item['qty'] ?></b>

<button type="button"
onclick="updateQty(<?= $key ?>,'tambah')">+</button>

</div>

</td>

<td><?=number_format($item['harga'],0,',','.')?></td>

<td><?=number_format($sub,0,',','.')?></td>

</tr>

<?php endforeach; ?>


<tr>
<td colspan="3"><b>Subtotal</b></td>
<td><b id="subtotal"><?=number_format($total,0,',','.')?></b></td>
</tr>


<tr id="ongkirRow" style="display:<?=$ongkir?'table-row':'none'?>">
<td colspan="3">Ongkir</td>
<td id="ongkirValue"><?=number_format($ongkir,0,',','.')?></td>
</tr>


<tr>
<td colspan="3"><b>Total Bayar</b></td>
<td><b id="totalBayar"><?=number_format($grandTotal,0,',','.')?></b></td>
</tr>

</table>

</table>

<h3 style="margin-top:20px">Data Pemesan</h3>

<input type="text" id="namaPemesan" placeholder="Nama Pemesan"
style="width:100%;padding:10px;margin-top:10px;border-radius:10px;border:1px solid #ccc">

<textarea id="alamatPemesan" placeholder="Alamat Lengkap"
style="width:100%;padding:10px;margin-top:10px;border-radius:10px;border:1px solid #ccc"></textarea>


</div>


<div class="box">

<h3>Metode Pemesanan</h3>

<label class="opsi-box">

<input type="radio"
name="metode"
value="COD"
<?=($_SESSION['metode']??'')=="COD"?'checked':''?>
onchange="updateMetode(this.value)">

Ambil di Tempat

</label>


<label class="opsi-box">

<input type="radio"
name="metode"
value="Diantar"
<?=($_SESSION['metode']??'')=="Diantar"?'checked':''?>
onchange="updateMetode(this.value)">

Diantar (+1000)

</label>


<h3>Metode Pembayaran</h3>

<label class="opsi-box">

<input type="radio"
name="pembayaran"
value="Cash"
<?=($_SESSION['pembayaran']??'')=="Cash"?'checked':''?>
onchange="showDana(this.value)">

Cash

</label>


<label class="opsi-box">

<input type="radio"
name="pembayaran"
value="DANA"
<?=($_SESSION['pembayaran']??'')=="DANA"?'checked':''?>
onchange="showDana(this.value)">

DANA

</label>


<div class="dana-box" id="danaBox" style="display:none;">

Transfer ke DANA<br>
Nomor : <b><?=$noDana?></b><br>
Atas Nama : <b><?=$namaDana?></b>

</div>
<button class="kirim" onclick="kirimWA()">Pesan via WhatsApp</button>

</div>

</div>


<script>

function rupiah(x){
return x.toLocaleString('id-ID')
}


/* UPDATE QTY */

function updateQty(index,aksi){

fetch("keranjang.php",{
method:"POST",
headers:{
"Content-Type":"application/x-www-form-urlencoded"
},
body:new URLSearchParams({
index:index,
aksi:aksi
})
})
.then(r=>r.json())
.then(data=>{

if(!data.keranjang[index]){
location.reload()
return
}

document.getElementById("qty"+index).innerText=
data.keranjang[index].qty

document.getElementById("subtotal").innerText=
rupiah(data.total)

if(data.ongkir>0){

document.getElementById("ongkirRow").style.display="table-row"

document.getElementById("ongkirValue").innerText=
rupiah(data.ongkir)

}else{

document.getElementById("ongkirRow").style.display="none"

}

document.getElementById("totalBayar").innerText=
rupiah(data.grandTotal)

})

}


/* UPDATE METODE */

function updateMetode(m){

fetch("keranjang.php",{
method:"POST",
headers:{
"Content-Type":"application/x-www-form-urlencoded"
},
body:new URLSearchParams({
metode:m
})
})

let subtotal=parseInt(
document.getElementById("subtotal").innerText.replace(/\./g,'')
)

let ongkir=(m=="Diantar")?1000:0

if(ongkir>0){

document.getElementById("ongkirRow").style.display="table-row"

document.getElementById("ongkirValue").innerText=
rupiah(ongkir)

}else{

document.getElementById("ongkirRow").style.display="none"

}

document.getElementById("totalBayar").innerText=
rupiah(subtotal+ongkir)

}


/* SHOW DANA */

function showDana(v){

let box = document.getElementById("danaBox")

if(v === "DANA"){
box.style.display = "block"
}else{
box.style.display = "none"
}

fetch("keranjang.php",{
method:"POST",
headers:{
"Content-Type":"application/x-www-form-urlencoded"
},
body:new URLSearchParams({
pembayaran:v
})
})

}


/* WHATSAPP */

function kirimWA(){

let nama=document.getElementById("namaPemesan").value
let alamat=document.getElementById("alamatPemesan").value

let total=document.getElementById("totalBayar").innerText

let metode=document.querySelector('input[name="metode"]:checked')?.value || "-"
let bayar=document.querySelector('input[name="pembayaran"]:checked')?.value || "-"

let pesan="Halo saya ingin memesan:%0A%0A"

pesan+="Pesanan:%0A"

<?php foreach($_SESSION['keranjang'] as $item){ ?>

pesan+="<?= $item['nama'] ?> x<?= $item['qty'] ?> = Rp <?= number_format($item['harga']*$item['qty'],0,',','.') ?>%0A"

<?php } ?>

pesan+="%0ANama: "+nama
pesan+="%0AAlamat: "+alamat

pesan+="%0A%0AMetode Pemesanan: "+metode
pesan+="%0AMetode Pembayaran: "+bayar

<?php
$subtotal = 0;
foreach($_SESSION['keranjang'] as $item){
    $subtotal += $item['harga'] * $item['qty'];
}
?>

pesan+="%0ASubtotal: Rp <?= number_format($subtotal,0,',','.') ?>"

<?php if($ongkir>0){ ?>
pesan+="%0AOngkir: Rp <?= number_format($ongkir,0,',','.') ?>"
<?php } ?>

pesan+="%0ATotal Bayar: Rp "+total

let nomor="6283853349892"

window.open(
"https://wa.me/"+nomor+"?text="+pesan,
"_blank"
)

}
window.addEventListener("DOMContentLoaded",function(){

let bayar=document.querySelector('input[name="pembayaran"]:checked')

if(bayar){
showDana(bayar.value)
}

})

</script>

</body>
</html>