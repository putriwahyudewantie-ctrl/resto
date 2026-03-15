<!DOCTYPE html>
<html>
<head>
<title>Booking Meja Restoran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f8f9fa;
font-family: Arial;
}

.header{
background:#8B0000;
color:white;
padding:20px;
text-align:center;
margin-bottom:20px;
}

.menu-img{
height:150px;
object-fit:cover;
}

.footer{
margin-top:50px;
background:#8B0000;
color:white;
text-align:center;
padding:10px;
}

</style>

</head>

<body>

<div class="header">
<h2>🍽 Booking Meja Restoran</h2>
<p>Silahkan reservasi meja dan pilih menu favorit anda</p>
</div>

<div class="container">

@if(session('success'))
<div class="alert alert-success text-center">
{{ session('success') }}
</div>
@endif


<div class="card shadow">
<div class="card-body">

<h4 class="mb-4 text-center">Form Booking</h4>

<form method="POST" action="/booking">
@csrf

<div class="row">

<div class="col-md-6 mb-3">
<label>Nama Pelanggan</label>
<input type="text" class="form-control" name="nama_pelanggan" required>
</div>

<div class="col-md-6 mb-3">
<label>No HP</label>
<input type="text" class="form-control" name="no_hp" required>
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Booking</label>
<input type="date" class="form-control" name="tanggal_booking" required>
</div>

<div class="col-md-6 mb-3">
<label>Jam Booking</label>
<input type="time" class="form-control" name="jam_booking" required>
</div>

<div class="col-md-6 mb-3">
<label>Jumlah Orang</label>
<input type="number" class="form-control" name="jumlah_orang" required>
</div>

<div class="col-md-6 mb-3">
<label>Nomor Meja</label>
<input type="number" class="form-control" name="nomor_meja" required>
</div>

<h4 class="mt-4 text-center">Pilih Menu & Jumlah Pesanan</h4>

<!-- BARIS 1 -->
<div class="row">

<!-- BAKSO -->
<div class="col-md-4">
<h5 class="mt-3">🍜 Bakso</h5>

<div class="mb-2">
<label>Bakso Mercon</label>
<input type="number" name="menu[bakso_mercon]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Bakso Tumpeng</label>
<input type="number" name="menu[bakso_tumpeng]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Bakso Beranak</label>
<input type="number" name="menu[bakso_beranak]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Bakso Telur</label>
<input type="number" name="menu[bakso_telur]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Bakso Daging</label>
<input type="number" name="menu[bakso_daging]" class="form-control" min="0">
</div>
</div>


<!-- DIMSUM -->
<div class="col-md-4">
<h5 class="mt-3">🥟 Dimsum</h5>

<div class="mb-2">
<label>Dimsum Mentai</label>
<input type="number" name="menu[dimsum_mentai]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Dimsum Keju</label>
<input type="number" name="menu[dimsum_keju]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Dimsum Ori</label>
<input type="number" name="menu[dimsum_ori]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Dimsum Goreng</label>
<input type="number" name="menu[dimsum_goreng]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Dimsum Matcha</label>
<input type="number" name="menu[dimsum_matcha]" class="form-control" min="0">
</div>
</div>


<!-- SPAGETI -->
<div class="col-md-4">
<h5 class="mt-3">🍝 Spageti</h5>

<div class="mb-2">
<label>Spageti Bolognese</label>
<input type="number" name="menu[spageti_bolognese]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Spageti Carbonara</label>
<input type="number" name="menu[spageti_carbonara]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Spageti Aglio Olio</label>
<input type="number" name="menu[spageti_aglio_olio]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Spageti Pesto</label>
<input type="number" name="menu[spageti_pesto]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Spageti Marinara</label>
<input type="number" name="menu[spageti_marinara]" class="form-control" min="0">
</div>
</div>

</div>


<!-- BARIS 2 -->
<div class="row mt-3">

<!-- SATE -->
<div class="col-md-4">
<h5 class="mt-3">🍢 Sate</h5>

<div class="mb-2">
<label>Sate Ayam</label>
<input type="number" name="menu[sate_ayam]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Sate Padang</label>
<input type="number" name="menu[sate_padang]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Sate Kambing</label>
<input type="number" name="menu[sate_kambing]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Sate Taichan</label>
<input type="number" name="menu[sate_taichan]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Sate Marangi</label>
<input type="number" name="menu[sate_marangi]" class="form-control" min="0">
</div>
</div>


<!-- MIE -->
<div class="col-md-4">
<h5 class="mt-3">🍜 Mie</h5>

<div class="mb-2">
<label>Mie Ayam</label>
<input type="number" name="menu[mie_ayam]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Mie Goreng</label>
<input type="number" name="menu[mie_goreng]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Mie Tumis</label>
<input type="number" name="menu[mie_tumis]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Mie Celor</label>
<input type="number" name="menu[mie_celor]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Mie Tec Tec</label>
<input type="number" name="menu[mie_tec_tec]" class="form-control" min="0">
</div>
</div>


<!-- NASI -->
<div class="col-md-4">
<h5 class="mt-3">🍚 Nasi</h5>

<div class="mb-2">
<label>Nasi Goreng Seafood</label>
<input type="number" name="menu[nasi_goreng_seafood]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Nasi Ayam Bakar</label>
<input type="number" name="menu[nasi_ayam_bakar]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Nasi Ikan Nila Bakar</label>
<input type="number" name="menu[nasi_ikan_nila_bakar]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Nasi Ayam Goreng</label>
<input type="number" name="menu[nasi_ayam_goreng]" class="form-control" min="0">
</div>

<div class="mb-2">
<label>Nasi Ikan Nila Goreng</label>
<input type="number" name="menu[nasi_ikan_nila_goreng]" class="form-control" min="0">
</div>

</div>
</div>

</div>
<div class="col-md-12 mb-3">
<label>Catatan</label>
<textarea class="form-control" name="catatan"></textarea>
</div>

<div class="text-center">
<button class="btn btn-danger px-5">
Booking Sekarang
</button>
</div>

</div>

</form>

</div>
</div>


<!-- MENU FOTO -->

<h3 class="mt-5 text-center">🍜 Menu Favorit</h3>

<div class="row mt-4">

<div class="col-md-3 mb-3">
<div class="card shadow">
<img src="/images/bakso.jpg" class="card-img-top menu-img">
<div class="card-body text-center">
<b>Bakso Mercon</b>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card shadow">
<img src="/images/dimsum.jpg" class="card-img-top menu-img">
<div class="card-body text-center">
<b>Dimsum Mentai</b>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card shadow">
<img src="/images/spageti.jpg" class="card-img-top menu-img">
<div class="card-body text-center">
<b>Spageti Bolognese</b>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card shadow">
<img src="/images/sate.jpg" class="card-img-top menu-img">
<div class="card-body text-center">
<b>Sate Ayam</b>
</div>
</div>
</div>

</div>

</div>

<div class="footer">
<p>© 2026 Booking Restoran | Project Laravel</p>
</div>

</body>
</html>