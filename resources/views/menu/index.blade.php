@extends('layouts.app')

@section('content')

<h2 class="page-title">🍜 Data Menu</h2>

<a href="{{ url('/menu/create') }}" class="btn btn-primary mb-3">
    + Tambah Menu
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card table-card">
    <div class="card-header">
        Daftar Menu Restoran
    </div>

    <div class="card-body">
        
        <div class="mb-4">
            <small class="text-muted d-block mb-2">Filter Kategori:</small>
            <a href="{{ url('/menu') }}" class="btn btn-sm {{ !request('category') ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill px-3">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ url('/menu?category=' . $cat->kategori) }}" 
                   class="btn btn-sm {{ request('category') == $cat->kategori ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3 ms-1">
                   {{ $cat->kategori }}
                </a>
            @endforeach
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Menu</th> <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($menu->gambar)
                                            <img src="{{ asset('images/menu/' . $menu->gambar) }}" 
                                                 alt="{{ $menu->nama_menu }}" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border-radius: 15px;">
                                        @else
                                            <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">
                                                No Pic
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <strong class="d-block">{{ $menu->nama_menu }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info">{{ $menu->kategori }}</span></td>
                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td>{{ $menu->deskripsi }}</td>
                            <td>
                                <a href="{{ url('/menu/'.$menu->id.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('/menu/'.$menu->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data menu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection