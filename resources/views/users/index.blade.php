@extends('layouts.app')

@section('content')
<div class="top-banner">
    <div>
        <h2><i class="fas fa-users me-2"></i>Manajemen User</h2>
        <p>Kelola akses akun dan otorisasi pengguna sistem</p>
    </div>
</div>

<div class="card table-card shadow-lg border-0 mt-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Pengguna Terdaftar</h5>
        <span class="badge bg-primary text-white">{{ count($users) }} Account</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="fw-bold">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger rounded-pill px-3 shadow-sm">
                                    <i class="fas fa-shield-alt me-1"></i> Admin
                                </span>
                            @else
                                <span class="badge bg-info text-white rounded-pill px-3 shadow-sm">
                                    <i class="fas fa-user me-1"></i> Customer
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini permanent?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-2 rounded-circle shadow-sm" style="width: 35px; height: 35px;" title="Hapus User">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary text-white shadow-sm">
                                    <i class="fas fa-lock me-1"></i> (Anda)
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
