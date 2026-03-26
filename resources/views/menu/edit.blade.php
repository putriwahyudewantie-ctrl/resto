@extends('layouts.app')

@section('content')

<h2 class="page-title">➕ Tambah Menu</h2>

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
        Form Tambah Menu
    </div>

    <div class="card-body">
        <form action="{{ url('/menu') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Menu</label>
                <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <small class="text-muted">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required min="0">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ url('/menu') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@endsection