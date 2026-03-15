@extends('layouts.app')

@section('content')

<h2 class="page-title">➕ Tambah Booking</h2>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card table-card">
    <div class="card-header">
        Form Tambah Booking
    </div>

    <div class="card-body">
        <form action="{{ url('/booking') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Booking</label>
                    <input type="date" name="tanggal_booking" class="form-control" value="{{ old('tanggal_booking') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Jam Booking</label>
                    <input type="time" name="jam_booking" class="form-control" value="{{ old('jam_booking') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" class="form-control" value="{{ old('jumlah_orang') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Meja</label>
                <input type="number" name="nomor_meja" class="form-control" value="{{ old('nomor_meja') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Menu</label>
                <div class="row">
                    @forelse($menus as $menu)
                        <div class="col-md-4 mb-2">
                            <div class="form-check border rounded p-3 bg-light">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="menu[]"
                                    value="{{ $menu->id }}"
                                    id="menu{{ $menu->id }}"
                                    {{ in_array($menu->id, old('menu', [])) ? 'checked' : '' }}
                                >
                                <label class="form-check-label ms-2" for="menu{{ $menu->id }}">
                                    <strong>{{ $menu->nama_menu }}</strong><br>
                                    <small>{{ $menu->kategori }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}</small>
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                Belum ada data menu. Tambahkan menu dulu.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control">{{ old('catatan') }}</textarea>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ url('/booking') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@endsection