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
                <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu') }}">
            </div>

            <div class="mb-3">
                <label>Foto Menu</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ old('harga') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ url('/menu') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@endsection