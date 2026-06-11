@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-pencil-square me-2"></i>Edit Periode</h2>
        <a href="{{ route('admin.periods') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

        <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.periods.update', $period->id ?? $id ?? 0) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Periode <span class="text-danger">*</span></label>
                    <input type="text" name="period_name" class="form-control" value="{{ old('period_name', $period->period_name ?? '') }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $period->start_date ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $period->end_date ?? '') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $period->description ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active', $period->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $period->is_active ?? 1) == 0 ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
