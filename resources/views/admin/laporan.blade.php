@extends('layouts.app')

@section('title', 'Laporan Aktivitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan Aktivitas Bimbingan
        @if(!empty($adminProdi))
            <span class="badge ms-2 fw-semibold" style="background: linear-gradient(135deg, #03045e, #0077b6); font-size: 0.7rem; border-radius: 8px; padding: 6px 14px; vertical-align: middle;">{{ $adminProdi }}</span>
        @endif
    </h2>
    <button onclick="window.print()" class="btn btn-primary">
        <i class="bi bi-printer"></i> Cetak Laporan
    </button>
</div>

<!-- Statistik Keseluruhan -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-people-fill" style="font-size: 2.5rem; color: var(--unej-red);"></i>
                <h3 class="mt-3">{{ $totalMahasiswa }}</h3>
                <p class="text-muted mb-0">Total Mahasiswa</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-person-badge-fill" style="font-size: 2.5rem; color: var(--unej-yellow);"></i>
                <h3 class="mt-3">{{ $totalDosen }}</h3>
                <p class="text-muted mb-0">Total Dosen</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-check-circle-fill" style="font-size: 2.5rem; color: var(--unej-green);"></i>
                <h3 class="mt-3">{{ $mahasiswaLayakSempro }}</h3>
                <p class="text-muted mb-0">Layak Sempro</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-trophy-fill" style="font-size: 2.5rem; color: var(--unej-green);"></i>
                <h3 class="mt-3">{{ $mahasiswaLayakSidang }}</h3>
                <p class="text-muted mb-0">Layak Sidang</p>
            </div>
        </div>
    </div>
</div>

<!-- Periode Jadwal Terbaru -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-calendar3"></i> Periode Jadwal Bimbingan Terbaru
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama Periode</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPeriods as $index => $period)
                        <tr>
                            <td class="ps-3">{{ $index + 1 }}</td>
                            <td><strong>{{ $period->period_name }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($period->start_date)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($period->end_date)->translatedFormat('d F Y') }}</td>
                            <td>
                                @if($period->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-calendar-x d-block fs-2 mb-2"></i>
                                Belum ada data periode jadwal
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .navbar, .sidebar-modern, .btn, .content-area { }
        aside { display: none !important; }
    }
</style>
@endsection
