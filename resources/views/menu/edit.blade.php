@extends('layouts.app')

@section('content')

<h2 class="page-title">✏️ Edit Menu</h2>

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
        Form Edit Menu
    </div>

    <div class="card-body">
        <form action="{{ url('/menu/'.$menu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu', $menu->nama_menu) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $menu->kategori) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ old('harga', $menu->harga) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>

            <button class="btn btn-success">Update</button>
            <a href="{{ url('/menu') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@endsection