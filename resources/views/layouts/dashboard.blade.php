@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard Restoran</h2>

<div class="row">

<div class="col-md-4">
<div class="card p-3">
<h5>Total Booking</h5>
<h3>{{ $totalBooking }}</h3>
</div>
</div>

<div class="col-md-4">
<div class="card p-3">
<h5>Booking Hari Ini</h5>
<h3>{{ $bookingHariIni }}</h3>
</div>
</div>

<div class="col-md-4">
<div class="card p-3">
<h5>Total Menu</h5>
<h3>{{ $totalMenu }}</h3>
</div>
</div>

</div>

@endsection