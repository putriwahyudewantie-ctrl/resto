@extends('layouts.app')

@section('content')

<h2 class="mb-4">Data Booking</h2>

<a href="/booking/create" class="btn btn-primary mb-3">
Tambah Booking
</a>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<div class="card p-3">

<table class="table">

<thead>
<tr>
<th>Nama</th>
<th>Tanggal</th>
<th>Jam</th>
<th>Orang</th>
<th>Meja</th>
<th>Menu</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($bookings as $booking)

<tr>

<td>{{ $booking->nama_pelanggan }}</td>
<td>{{ $booking->tanggal_booking }}</td>
<td>{{ $booking->jam_booking }}</td>
<td>{{ $booking->jumlah_orang }}</td>
<td>{{ $booking->nomor_meja }}</td>

<td>

@php
$menus = json_decode($booking->menu);
@endphp

@if($menus)
@foreach($menus as $m)
<span class="badge bg-secondary">{{ $m }}</span>
@endforeach
@endif

</td>

<td>

<a href="/booking/{{ $booking->id }}/edit"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="/booking/{{ $booking->id }}" method="POST" style="display:inline">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection