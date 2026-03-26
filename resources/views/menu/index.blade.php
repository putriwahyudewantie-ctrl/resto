@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">

    <h2 class="page-title mb-3">🍜 Data Menu</h2>

    <a href="{{ url('/menu/create') }}" class="btn btn-primary mb-3">
        + Tambah Menu
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ url('/menu') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Cari Nama Menu</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Masukkan nama menu..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Filter Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ url('/menu') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card table-card" id="menu-table">
        <div class="card-header">
            Daftar Menu Restoran
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                            <tr>
                                <td width="110">
                                    @if($menu->gambar)
                                        <img src="{{ asset('images/menu/' . $menu->gambar) }}"
                                             alt="{{ $menu->nama_menu }}"
                                             width="80"
                                             height="80"
                                             class="rounded border shadow-sm"
                                             style="object-fit:cover;"
                                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($menu->nama_menu) }}&background=random&color=fff&size=80&bold=true';">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($menu->nama_menu) }}&background=random&color=fff&size=80&bold=true" width="80" height="80" class="rounded border shadow-sm" alt="No Pic">
                                    @endif
                                </td>
                                <td><strong style="color: #0f2f66;">{{ $menu->nama_menu }}</strong></td>
                                <td>
                                    <span class="badge-soft-blue">{{ $menu->kategori }}</span>
                                </td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td style="font-size: 13px; color: #475569;">{{ $menu->deskripsi }}</td>
                                <td>
                                    <a href="{{ url('/menu/'.$menu->id.'/edit') }}" class="btn btn-warning btn-sm" style="color: #fff; font-weight: bold;">
                                        Edit
                                    </a>

                                    <form action="{{ url('/menu/'.$menu->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus menu ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm" style="font-weight: bold; cursor:pointer;">
                                            <i class="fa fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data menu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $menus->fragment('menu-table')->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

</div>

@endsection