@extends('layouts.app')

@section('content')
<div class="top-banner">
    <div>
        <h2><i class="fas fa-plus-circle me-2"></i>Tambah Meja Baru</h2>
        <p>Manajemen fasilitas restoran untuk pelanggan</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card table-card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Form Data Meja</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('meja.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label font-weight-bold">Nomor Meja</label>
                        <input type="number" name="no_meja" class="form-control @error('no_meja') is-invalid @enderror" value="{{ old('no_meja') }}" placeholder="Contoh: 10" required>
                        @error('no_meja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-weight-bold">Kapasitas (Orang)</label>
                        <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas') }}" placeholder="Contoh: 4" required>
                        @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-weight-bold">Status Awal</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Maintenance" {{ old('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance (Perbaikan)</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('meja.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-5 shadow">
                            <i class="fas fa-save me-2"></i>Simpan Data Meja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
