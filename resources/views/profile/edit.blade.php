@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="page-title mb-4">Pengaturan Profil</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success shadow-sm mb-4" style="border-radius:12px;">
                <i class="fas fa-check-circle me-1"></i> Profil berhasil diperbarui.
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger shadow-sm mb-4" style="border-radius:12px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card: Informasi Profil -->
        <div class="card bg-white rounded-4 shadow-sm border-0 mb-4 p-2">
            <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <h5 class="fw-bold m-0" style="color:#0f2f66;">Informasi Profil</h5>
                <p class="text-muted small">Perbarui informasi nama dan email akun Anda.</p>
            </div>
            <div class="card-body">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label text-secondary fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" style="border-radius:12px;">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label text-secondary fw-semibold">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" style="border-radius:12px;">
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius:10px;">Simpan Profil</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card: Ganti Password -->
        <div class="card bg-white rounded-4 shadow-sm border-0 p-2">
            <div class="card-header bg-transparent border-0 pt-3 pb-0">
                <h5 class="fw-bold m-0" style="color:#0f2f66;">Perbarui Password</h5>
                <p class="text-muted small">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label text-secondary fw-semibold">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password" style="border-radius:12px;">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary fw-semibold">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" style="border-radius:12px;">
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label text-secondary fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" style="border-radius:12px;">
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-dark px-4 py-2" style="border-radius:10px;">Ganti Password</button>
                        
                        @if (session('status') === 'password-updated')
                            <p class="text-success m-0 small fw-bold">Tersimpan.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
