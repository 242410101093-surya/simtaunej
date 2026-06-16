@extends('layouts.app')

@section('title', 'Edit Periode Jadwal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-pencil-square text-primary me-2"></i>
        <span style="color: #0d1b2a; font-weight: 700;">Edit Periode Jadwal</span>
    </h2>
    <a href="{{ route('admin.periods') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0" style="border-radius: 1rem; max-width: 700px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.periods.update', $period->id ?? $id ?? 0) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Periode <span class="text-danger">*</span></label>
                <input type="text" name="period_name" class="form-control @error('period_name') is-invalid @enderror"
                       value="{{ old('period_name', $period->period_name ?? '') }}"
                       placeholder="Contoh: Sempro Gelombang 1"
                       required>
                @error('period_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Kategori Jadwal <span class="text-danger">*</span></label>
                <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                    <option value="Sempro"         {{ old('jenis', $period->jenis ?? 'Sempro') === 'Sempro' ? 'selected' : '' }}>Sempro (Seminar Proposal)</option>
                    <option value="Semhas"         {{ old('jenis', $period->jenis ?? '') === 'Semhas' ? 'selected' : '' }}>Semhas (Seminar Hasil)</option>
                    <option value="Sidang Skripsi" {{ old('jenis', $period->jenis ?? '') === 'Sidang Skripsi' ? 'selected' : '' }}>Sidang Skripsi</option>
                </select>
                @error('jenis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date', $period->start_date ?? '') }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                           value="{{ old('end_date', $period->end_date ?? '') }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active', $period->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $period->is_active ?? 1) == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Deskripsi tambahan mengenai periode ini (opsional)">{{ old('description', $period->description ?? '') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.periods') }}" class="btn btn-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
