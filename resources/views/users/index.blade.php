@extends('layouts.app')

@section('content')

<style>
    .user-avatar {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 800; color: white;
        flex-shrink: 0;
    }
    .role-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;
    }
    .role-admin    { background: #fef9c3; color: #92400e; border: 1px solid #fde68a; }
    .role-dapur    { background: #fce7f3; color: #9d174d; border: 1px solid #fbcfe8; }
    .role-customer { background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe; }
    .role-select {
        font-size: 12px; font-weight: 600; border-radius: 8px;
        padding: 4px 8px; border: 1.5px solid #e2e8f0; color: #1e293b;
        background: #f8fafc; cursor: pointer;
    }
    .role-select:focus { border-color: #e67e22; outline: none; box-shadow: 0 0 0 2px rgba(230,126,34,0.15); }
</style>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    </div>
@endif

<div class="card table-card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0 fw-bold text-navy"><i class="fas fa-users-cog me-2"></i>User Management</h5>
        <a href="{{ route('users.create') }}" class="btn-resto-accent btn-sm py-2">
            <i class="fas fa-user-plus"></i> Tambah User Baru
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width:35%;">Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar" style="background: linear-gradient(135deg, #1e3a5f, #e67e22);">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="color:#1e293b;">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <span style="font-size:10px; color:#e67e22; font-weight:700;">● Anda Sedang Login</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td style="color:#64748b;">{{ $user->email }}</td>

                        <td>
                            @if($user->role === 'admin')
                                <span class="role-badge role-admin"><i class="fas fa-shield-alt"></i> Admin</span>
                            @elseif($user->role === 'dapur')
                                <span class="role-badge role-dapur"><i class="fas fa-fire-burner"></i> Dapur</span>
                            @else
                                <span class="role-badge role-customer"><i class="fas fa-user"></i> Customer</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning border-2 rounded-2" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus user {{ $user->name }} secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-2 rounded-2" title="Hapus User">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light border-2 rounded-2 disabled" title="Tidak Bisa Hapus Diri Sendiri">
                                        <i class="fas fa-trash-alt text-muted"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection