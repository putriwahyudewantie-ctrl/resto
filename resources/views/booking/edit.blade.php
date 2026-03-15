<!DOCTYPE html>
<html>
<head>

<title>Edit Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="container mt-5">

<h2>Edit Booking</h2>

<form action="/booking/{{ $booking->id }}" method="POST">

@csrf
@method('PUT')

<input type="text" name="nama_pelanggan" class="form-control mb-2" value="{{ $booking->nama_pelanggan }}">

<input type="text" name="no_hp" class="form-control mb-2" value="{{ $booking->no_hp }}">

<input type="date" name="tanggal_booking" class="form-control mb-2" value="{{ $booking->tanggal_booking }}">

<input type="time" name="jam_booking" class="form-control mb-2" value="{{ $booking->jam_booking }}">

<input type="number" name="jumlah_orang" class="form-control mb-2" value="{{ $booking->jumlah_orang }}">

<input type="number" name="nomor_meja" class="form-control mb-2" value="{{ $booking->nomor_meja }}">

<input type="text" name="menu" class="form-control mb-2" value="{{ $booking->menu }}">

<textarea name="catatan" class="form-control mb-3">{{ $booking->catatan }}</textarea>

<button class="btn btn-success">
Update
</button>

</form>

</body>
</html>