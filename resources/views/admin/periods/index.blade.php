{{-- File: resources/views/admin/periods/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Periode Jadwal')

@section('content')
<style>
    .ui-title {
        color: #0d1b2a !important;
        font-weight: 700 !important;
        letter-spacing: -0.025em;
    }
    .ui-icon-main {
        color: #0077b6 !important;
    }
    .bg-gradient-blue {
        background: linear-gradient(to right, #03045e, #0077b6) !important;
    }
    .tab-active-timeline {
        background: linear-gradient(to right, #03045e, #0077b6) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(3, 4, 94, 0.15);
    }
    .btn-custom-action {
        border-radius: 0.5rem; 
        padding: 10px 18px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
</style>

<div class="mb-4 d-flex align-items-center gap-3">
    <h2>
        <i class="bi bi-calendar-week ui-icon-main me-1"></i> 
        <span class="ui-title">DAFTAR PERIODE JADWAL BIMBINGAN FASILKOM</span>
    </h2>
</div>

<div class="mb-4 d-flex gap-2">
    <a href="{{ route('admin.periods.create') }}" class="btn text-white bg-gradient-blue shadow-sm d-flex align-items-center gap-2 btn-custom-action">
        <i class="bi bi-plus-lg"></i> <span>Tambah Periode Baru</span>
    </a>
    <button class="btn btn-outline-primary d-flex align-items-center gap-2 btn-custom-action">
        <i class="bi bi-arrow-clockwise"></i> <span>Sinkronisasi Jadwal</span>
    </button>
</div>

<div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
    <div class="card-body p-4 bg-white" style="border-radius: 1rem;">
        <div class="row g-3 text-center">
            <div class="col-md-4">
                <button class="btn w-100 fs-6 fw-semibold tab-active-timeline py-3" style="border-radius: 0.75rem;">
                    <i class="bi bi-layout-text-sidebar-reverse me-1"></i> Jadwal Sempro
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn w-100 fs-6 fw-semibold btn-light py-3 text-secondary" style="border-radius: 0.75rem; border: 1px solid #dee2e6;">
                    <i class="bi bi-cpu me-1"></i> Jadwal Semhas
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn w-100 fs-6 fw-semibold btn-light py-3 text-secondary" style="border-radius: 0.75rem; border: 1px solid #dee2e6;">
                    <i class="bi bi-code-slash"></i> Jadwal Sidang Skripsi
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-semibold text-dark">
            <i class="bi bi-calendar3 text-primary me-1"></i> Daftar Periode Jadwal Aktif
        </div>
        <span class="badge bg-secondary rounded-pill px-3">{{ $periods->count() }} Total Periode</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small fw-bold">
                    <tr>
                        <th style="width: 60px;" class="ps-3">No</th>
                        <th>Nama Kegiatan / Gelombang</th>
                        <th>Kategori</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th style="width: 120px;" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periods as $index => $prd)
                        <tr>
                            <td class="ps-3 fw-medium text-secondary">{{ $index + 1 }}</td>
                            
                            {{-- FIXED 1: Mengubah nama menjadi period_name sesuai database --}}
                            <td class="fw-semibold text-dark">{{ $prd->period_name }}</td>
                            
                            <td>
                                {{-- Menyesuaikan jika jenis/kategori dibedakan berdasarkan nama/sistem Anda --}}
                                <span class="badge bg-light text-primary border border-primary-subtle px-2.5 py-1">
                                    {{ $prd->jenis ?? 'Seminar' }}
                                </span>
                            </td>
                            
                            {{-- FIXED 2: Mengubah tgl_mulai menjadi start_date --}}
                            <td class="text-secondary">
                                <i class="bi bi-calendar-event me-1"></i> 
                                {{ \Carbon\Carbon::parse($prd->start_date)->translatedFormat('d F Y') }}
                            </td>
                            
                            {{-- FIXED 3: Mengubah tgl_selesai menjadi end_date --}}
                            <td class="text-secondary">
                                <i class="bi bi-calendar-check me-1"></i> 
                                {{ \Carbon\Carbon::parse($prd->end_date)->translatedFormat('d F Y') }}
                            </td>
                            
                            <td>
                                {{-- FIXED 4: Menyesuaikan status keaktifan berbasis integer is_active --}}
                                @if(isset($prd->is_active) && $prd->is_active == 1)
                                    <span class="badge bg-success rounded-pill px-3 py-1.5">Aktif</span>
                                @elseif(isset($prd->status) && $prd->status == 'Aktif')
                                    <span class="badge bg-success rounded-pill px-3 py-1.5">Aktif</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-1.5">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center pe-3">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.periods.edit', $prd->id) }}" class="btn btn-sm btn-outline-primary" title="Edit" style="border-radius: 0.375rem;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.periods.delete', $prd->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" style="border-radius: 0.375rem;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i> Belum ada data periode jadwal akademik.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-5 text-center text-secondary mb-3">
    <h5 class="fw-bold text-dark">Mahasiswa dapat mendaftar Sempro mulai tanggal 1-5 setiap bulannya.</h5>
</div>
@endsection