@extends('layouts.app')

@section('content')

<h2 class="page-title"><i class="fas fa-edit me-2"></i> Edit Menu: {{ $menu->nama_menu }}</h2>

<div class="card table-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-form me-2"></i> Formulir Perubahan Menu</span>
        <a href="{{ url('/menu') }}" class="btn btn-sm btn-outline-light"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/menu/'.$menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu', $menu->nama_menu) }}" required placeholder="Contoh: Nasi Goreng Spesial">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $menu->kategori) }}" required placeholder="Contoh: Makanan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" value="{{ old('harga', $menu->harga) }}" required min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan deskripsi menu di sini...">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Menu (Opsional)</label>
                        <div class="mb-2">
                             @if($menu->gambar)
                                <img src="{{ asset('images/menu/' . $menu->gambar) }}" class="rounded shadow-sm border" width="100%" style="height: 200px; object-fit: cover;">
                             @else
                                <div class="bg-light d-flex align-items-center justify-content-center border rounded" style="height: 200px;">
                                    <span class="text-muted">Belum ada foto</span>
                                </div>
                             @endif
                        </div>
                        <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted d-block mt-2">Format: JPG, PNG. Maks 2MB.</small>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ url('/menu') }}" class="btn btn-light px-4 py-2 border fw-bold text-muted">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection