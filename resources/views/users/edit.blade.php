@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold text-navy mb-0"><i class="fas fa-user-edit me-2"></i>Edit Data User</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role Akses</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                            <option value="dapur" {{ $user->role == 'dapur' ? 'selected' : '' }}>Dapur (Manajemen Pesanan)</option>
                            <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer (Hanya Pesan)</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="p-3 mb-4 rounded-3" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                        <h6 class="fw-bold text-muted small mb-2">Ganti Password (Opsional)</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ganti">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-light px-4 fw-bold">Batal</a>
                        <button type="submit" class="btn text-white px-4 fw-bold" style="background: #e67e22;">Perbarui User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
