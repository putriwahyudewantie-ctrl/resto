<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Meja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5');
            background-size: cover;
            background-position: center;
        }

        .overlay {
            background: rgba(0,0,0,0.7);
            min-height: 100vh;
            padding-top: 50px;
        }

        .card {
            border-radius: 15px;
            background: white;
        }

        tr:hover {
            background-color: #f2f2f2;
            transition: 0.3s;
        }

        button:hover {
            transform: scale(1.05);
            transition: 0.2s;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand fw-bold">🍽️ RestoKu</span>
    </div>
</nav>

<div class="overlay">
<div class="container">

<div class="card shadow p-4">

<h2 class="text-center fw-bold">🍽️ Reservasi Meja RestoKu</h2>
<p class="text-center text-muted">Pesan meja favoritmu dengan mudah dan cepat</p>

<!-- ALERT -->
@if(session('success'))
<div class="alert alert-success text-center">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger text-center">
    {{ session('error') }}
</div>
@endif

<!-- AUTO BOOK -->
<form action="{{ route('meja.auto') }}" method="POST" class="mb-4">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-4">
            <input type="number" name="jumlah" class="form-control" placeholder="Jumlah orang" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning w-100">Auto Booking</button>
        </div>
    </div>
</form>

<table class="table table-bordered text-center align-middle">
<thead class="table-dark">
<tr>
<th>No Meja</th>
<th>Kapasitas</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
@foreach ($mejas as $meja)
<tr>
<td>{{ $meja->no_meja }}</td>
<td>{{ $meja->kapasitas }} Orang</td>
<td>
@if($meja->status == 'tersedia')
<span class="badge bg-success">Tersedia</span>
@else
<span class="badge bg-danger">Penuh</span>
@endif
</td>

<td>
@if($meja->status == 'tersedia')
<form action="{{ route('meja.book', $meja->id) }}" method="POST">
@csrf
<button class="btn btn-primary btn-sm">Booking</button>
</form>
@else
<button class="btn btn-secondary btn-sm" disabled>Penuh</button>
@endif
</td>

</tr>
@endforeach
</tbody>
</table>

</div>
</div>
</div>

</body>
</html>