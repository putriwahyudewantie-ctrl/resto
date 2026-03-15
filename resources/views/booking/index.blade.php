@extends('layouts.app')

@section('content')

<h2 class="page-title">📅 Data Booking</h2>

<a href="{{ url('/booking/create') }}" class="btn btn-primary mb-3">
    + Tambah Booking
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card table-card">
    <div class="card-header">
        Daftar Booking Restoran
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Orang</th>
                        <th>Meja</th>
                        <th>Menu</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->nama_pelanggan }}</td>
                            <td>{{ $booking->tanggal_booking }}</td>
                            <td>{{ $booking->jam_booking }}</td>
                            <td><span class="badge-soft-blue">{{ $booking->jumlah_orang }} orang</span></td>
                            <td><span class="badge-soft-green">Meja {{ $booking->nomor_meja }}</span></td>
                            <td style="max-width: 320px;">
                                @php
                                    $selectedMenus = $booking->menu ?? [];
                                @endphp

                                @forelse($selectedMenus as $menuId)
                                    <span class="badge-soft-gray">
                                        {{ $allMenus[$menuId] ?? 'Menu tidak ditemukan' }}
                                    </span>
                                @empty
                                    <span class="text-muted">Tidak ada menu</span>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ url('/booking/'.$booking->id.'/edit') }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ url('/booking/'.$booking->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus booking ini?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data booking</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection