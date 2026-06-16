{{-- File: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Kepala Prodi')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-speedometer2"></i> Dashboard Kepala Prodi
        @if(!empty($adminProdi))
            <span class="badge ms-2 fw-semibold" style="background: linear-gradient(135deg, #03045e, #0077b6); font-size: 0.7rem; border-radius: 8px; padding: 6px 14px; vertical-align: middle;">{{ $adminProdi }}</span>
        @endif
    </h2>
    <p class="text-muted">Selamat datang, {{ auth()->user()->name }}
        @if(!empty($adminProdi))
            — Menampilkan data mahasiswa <strong>{{ $adminProdi }}</strong>
        @endif
    </p>
</div>

<!-- Statistik Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center h-100 border-0 shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #FDF2F2 100%); border-left: 4px solid var(--unej-red) !important; padding: 20px !important;">
            <div class="card-body py-2">
                <div class="d-inline-flex p-3 bg-white shadow-sm rounded-3 text-danger mb-3" style="color: var(--unej-red) !important;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $totalMahasiswa }}</h2>
                <p class="text-secondary small mb-0 fw-semibold">Total Mahasiswa{{ !empty($adminProdi) ? ' (' . $adminProdi . ')' : '' }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center h-100 border-0 shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #FFFBEF 100%); border-left: 4px solid var(--unej-yellow) !important; padding: 20px !important;">
            <div class="card-body py-2">
                <div class="d-inline-flex p-3 bg-white shadow-sm rounded-3 text-warning mb-3" style="color: var(--unej-yellow) !important;">
                    <i class="bi bi-person-badge-fill fs-3"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $totalDosen }}</h2>
                <p class="text-secondary small mb-0 fw-semibold">Total Dosen</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center h-100 border-0 shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #ECFDF5 100%); border-left: 4px solid var(--unej-green) !important; padding: 20px !important;">
            <div class="card-body py-2">
                <div class="d-inline-flex p-3 bg-white shadow-sm rounded-3 text-success mb-3" style="color: var(--unej-green) !important;">
                    <i class="bi bi-file-earmark-text-fill fs-3"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $totalBimbingan }}</h2>
                <p class="text-secondary small mb-0 fw-semibold">Total Bimbingan</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center h-100 border-0 shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #EFF6FF 100%); border-left: 4px solid var(--unej-blue) !important; padding: 20px !important;">
            <div class="card-body py-2">
                <div class="d-inline-flex p-3 bg-white shadow-sm rounded-3 text-primary mb-3" style="color: var(--unej-blue) !important;">
                    <i class="bi bi-trophy-fill fs-3"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $mahasiswaLayakSidang }}</h2>
                <p class="text-secondary small mb-0 fw-semibold">Layak Sidang</p>
            </div>
        </div>
    </div>
</div>

<!-- Progress Overview -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up-arrow"></i> Progress Mahasiswa
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-3">
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar bg-secondary" role="progressbar"
                                     style="width: {{ $totalMahasiswa > 0 ? (($totalMahasiswa - $mahasiswaLayakSempro) / $totalMahasiswa * 100) : 0 }}%">
                                </div>
                            </div>
                            <h4 class="fw-bold">{{ $totalMahasiswa - $mahasiswaLayakSempro }}</h4>
                            <p class="text-muted mb-0">Bimbingan Awal</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ $totalMahasiswa > 0 ? (($mahasiswaLayakSempro - $mahasiswaLayakSidang) / $totalMahasiswa * 100) : 0 }}%; background: var(--unej-yellow)">
                                </div>
                            </div>
                            <h4 class="fw-bold">{{ $mahasiswaLayakSempro - $mahasiswaLayakSidang }}</h4>
                            <p class="text-muted mb-0">Layak Sempro</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $totalMahasiswa > 0 ? ($mahasiswaLayakSidang / $totalMahasiswa * 100) : 0 }}%">
                                </div>
                            </div>
                            <h4 class="fw-bold">{{ $mahasiswaLayakSidang }}</h4>
                            <p class="text-muted mb-0">Layak Sidang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Aktivitas Bimbingan Terbaru -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Aktivitas Bimbingan Terbaru
                </h5>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($recentBimbingan as $bimbingan)
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0 me-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                 style="width: 40px; height: 40px;">
                                <i class="bi bi-file-text" style="color: var(--unej-red);"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $bimbingan->mahasiswa->name }}</h6>
                            <p class="mb-1 small text-muted">{{ Str::limit($bimbingan->judul, 50) }}</p>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i>
                                    {{ $bimbingan->tanggal_upload->diffForHumans() }}
                                </small>
                                <span class="{{ $bimbingan->getStatusBadge() }} badge-sm">
                                    {{ $bimbingan->getStatusText() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada aktivitas bimbingan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Status Mahasiswa -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-person-check"></i> Status Mahasiswa Terbaru
                </h5>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($mahasiswa as $mhs)
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1">{{ $mhs->name }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-card-text"></i> {{ $mhs->nim_nip }}
                            </small>
                        </div>
                        <div class="text-end">
                            @if($mhs->statusMahasiswa?->layak_sidang)
                                <span class="badge bg-success mb-1">
                                    <i class="bi bi-trophy-fill"></i> Layak Sidang
                                </span>
                            @elseif($mhs->statusMahasiswa?->layak_sempro)
                                <span class="badge" style="background: var(--unej-yellow); color: #333;">
                                    <i class="bi bi-check-circle-fill"></i> Layak Sempro
                                </span>
                            @else
                                <span class="badge bg-secondary mb-1">
                                    <i class="bi bi-hourglass-split"></i> Bimbingan Awal
                                </span>
                            @endif
                            <div class="progress" style="height: 5px; width: 100px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $mhs->statusMahasiswa?->getProgresPercentage() ?? 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-people" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada mahasiswa terdaftar</p>
                        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-unej-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Tambah Mahasiswa
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
