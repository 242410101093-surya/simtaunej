{{-- File: resources/views/dosen/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-person-workspace"></i> Dashboard Dosen Pembimbing</h2>
    <p class="text-muted">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card text-center h-100 border-0 shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #FDF2F2 100%); border-left: 5px solid var(--unej-red) !important; padding: 20px !important;">
            <div class="card-body py-2">
                <div class="d-inline-flex p-3 bg-white shadow-sm rounded-3 text-danger mb-3" style="color: var(--unej-red) !important;">
                    <i class="bi bi-people fs-3"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $totalMahasiswa }}</h2>
                <p class="text-secondary small mb-3 fw-semibold">Mahasiswa Bimbingan Anda</p>
                <a href="{{ route('dosen.mahasiswa.index') }}" class="btn btn-sm btn-unej-primary">
                    <i class="bi bi-eye me-1"></i> Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center h-100 border-0 shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #FFFBEF 100%); border-left: 5px solid var(--unej-yellow) !important; padding: 20px !important;">
            <div class="card-body py-2">
                <div class="d-inline-flex p-3 bg-white shadow-sm rounded-3 text-warning mb-3" style="color: var(--unej-yellow) !important;">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ $pendingReview }}</h2>
                <p class="text-secondary small mb-3 fw-semibold">Berkas Menunggu Review</p>
                @if($pendingReview > 0)
                    <span class="badge bg-danger px-3 py-1.5 rounded-pill shadow-sm" style="font-weight:600;">
                        <i class="bi bi-exclamation-circle me-1"></i> Perlu Review Segera
                    </span>
                @else
                    <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill border border-success-subtle fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> Selesai Semua
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 border-warning border-2 shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-calendar-event-fill"></i> Permintaan Jadwal Bimbingan Baru ({{ $appointments->count() }})
        </h5>
    </div>
    <div class="card-body">
        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle bg-white rounded shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Rencana Tanggal & Waktu</th>
                            <th>Catatan Pengajuan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $app)
                            <tr>
                                <td>
                                    <strong>{{ $app->mahasiswa->name }}</strong><br>
                                    <small class="text-muted">{{ $app->mahasiswa->nim_nip }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><i class="bi bi-calendar3"></i> {{ $app->scheduled_date }}</span><br>
                                    <small class="text-primary fw-bold"><i class="bi bi-clock"></i> {{ $app->scheduled_time }} WIB</small>
                                </td>
                                <td><em class="text-muted">"{{ $app->notes ?? 'Tidak ada catatan' }}"</em></td>
                                <td>
                                    <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-calendar-check text-muted" style="font-size: 2.5rem;"></i>
                <p class="text-muted mt-2 mb-0">Tidak ada pengajuan bimbingan yang berstatus pending.</p>
            </div>
        @endif
    </div>
</div>

@if($bimbinganPending->count() > 0)
<div class="card mb-4 border-danger border-2 shadow-sm">
    <div class="card-header text-white" style="background: var(--unej-red);">
        <h5 class="mb-0">
            <i class="bi bi-exclamation-circle-fill"></i>
            Bimbingan Menunggu Review ({{ $bimbinganPending->count() }})
        </h5>
    </div>
    <div class="card-body">
        @foreach($bimbinganPending as $bimbingan)
            @php
                // Mengubah string tanggal_upload menjadi objek Carbon agar aman diformat
                $tglUpload = \Carbon\Carbon::parse($bimbingan->tanggal_upload);
            @endphp
            <div class="card mb-3 border-start border-danger border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-person-circle" style="font-size: 1.5rem; color: var(--unej-red);"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $bimbingan->mahasiswa->name }}</h6>
                                    <p class="mb-2">{{ $bimbingan->judul }}</p>
                                    <div class="d-flex gap-2 align-items-center flex-wrap">
                                        <span class="badge {{ $bimbingan->fase == 'sempro' ? 'bg-info' : 'bg-primary' }}">
                                            {{ strtoupper($bimbingan->fase) }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar"></i>
                                            {{ $tglUpload->format('d M Y, H:i') }}
                                        </small>
                                        <small class="text-danger">
                                            <i class="bi bi-clock"></i>
                                            {{ $tglUpload->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('dosen.bimbingan.review', $bimbingan->id) }}"
                               class="btn btn-unej-primary">
                                <i class="bi bi-eye-fill"></i> Review Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
<div class="alert alert-success border-0 shadow-sm mb-4">
    <div class="d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-3" style="font-size: 2rem;"></i>
        <div>
            <h6 class="mb-0">Semua Bimbingan Sudah Direview!</h6>
            <small>Tidak ada bimbingan yang menunggu review saat ini.</small>
        </div>
    </div>
</div>
@endif

@if($mahasiswaBimbingan->count() > 0)
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="bi bi-people-fill"></i> Mahasiswa Bimbingan Saya
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($mahasiswaBimbingan as $mhs)
                <div class="col-md-6 mb-3">
                    <div class="card h-100 border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">{{ $mhs->name }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-card-text"></i> {{ $mhs->nim_nip }}
                                    </small>
                                </div>
                                <div>
                                    @if($mhs->statusMahasiswa?->layak_sidang)
                                        <span class="badge bg-success">
                                            <i class="bi bi-trophy-fill"></i> Layak Sidang
                                        </span>
                                    @elseif($mhs->statusMahasiswa?->layak_sempro)
                                        <span class="badge" style="background: var(--unej-yellow); color: #333;">
                                            <i class="bi bi-check-circle-fill"></i> Layak Sempro
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-hourglass-split"></i> Bimbingan Awal
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                @php
                                    $progres = $mhs->statusMahasiswa?->getProgresPercentage() ?? 0;
                                    if ($progres >= 100) {
                                        $barStyle = 'background: linear-gradient(90deg, #10B981 0%, #059669 50%, #34D399 100%); box-shadow: 0 0 8px rgba(16,185,129,0.6);';
                                        $barClass = 'progress-bar progress-bar-striped progress-bar-animated';
                                    } elseif ($progres >= 50) {
                                        $barStyle = 'background: linear-gradient(90deg, #F59E0B 0%, #10B981 100%);';
                                        $barClass = 'progress-bar';
                                    } else {
                                        $barStyle = 'background: #CBD5E1;';
                                        $barClass = 'progress-bar';
                                    }
                                @endphp
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Progress</small>
                                    <small class="fw-bold {{ $progres >= 100 ? 'text-success' : ($progres >= 50 ? 'text-warning' : 'text-muted') }}">{{ $progres }}%</small>
                                </div>
                                <div class="progress" style="height: 12px; border-radius: 8px; background: #E2E8F0;">
                                    <div class="{{ $barClass }}"
                                         role="progressbar"
                                         style="width: {{ $progres }}%; border-radius: 8px; {{ $barStyle }}"
                                         aria-valuenow="{{ $progres }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('dosen.mahasiswa.show', $mhs->id) }}"
                               class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('dosen.mahasiswa.index') }}" class="btn btn-unej-primary">
                <i class="bi bi-arrow-right-circle"></i> Lihat Semua Mahasiswa
            </a>
        </div>
    </div>
</div>
@endif

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="bi bi-calendar-check"></i> Jadwal Saya
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h6 class="mb-3">Jadwal Bimbingan Mendatang</h6>
                @if($upcomingAppointments->count() > 0)
                    @foreach($upcomingAppointments as $appointment)
                        @php
                            $isToday = \Carbon\Carbon::parse($appointment->scheduled_date)->isToday();
                            $dateOnly = \Carbon\Carbon::parse($appointment->scheduled_date)->toDateString();
                            $jadwalTime = \Carbon\Carbon::parse($dateOnly . ' ' . $appointment->scheduled_time);
                            $minsLeft = \Carbon\Carbon::now()->diffInMinutes($jadwalTime, false);
                        @endphp
                        <div class="card mb-2 border-start border-3 {{ ($isToday && $minsLeft <= 60 && $minsLeft > 0) ? 'border-warning' : 'border-primary' }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('d M Y') }}</strong> <span class="text-muted mx-1">|</span>
                                        <strong>{{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }} WIB</strong>
                                        <br>
                                        <small class="text-muted">{{ $appointment->mahasiswa->name }}</small>
                                    </div>
                                    <div class="d-flex flex-column align-items-end gap-1">
                                        @if($isToday && $minsLeft <= 60 && $minsLeft > 0)
                                            <span class="badge bg-warning text-dark"><i class="bi bi-alarm"></i> Segera ({{ $minsLeft }} mnt)</span>
                                        @elseif($isToday)
                                            <span class="badge bg-primary">Hari Ini</span>
                                        @else
                                            <span class="badge bg-info text-dark">Mendatang</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">Tidak ada jadwal bimbingan mendatang</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="bi bi-clock-history"></i> Riwayat Review Berkas Terbaru
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Judul</th>
                        <th>Fase</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBimbingan as $bimbingan)
                        @php
                            $tglRecent = \Carbon\Carbon::parse($bimbingan->tanggal_upload);
                        @endphp
                        <tr>
                            <td>
                                <small>{{ $tglRecent->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ $tglRecent->format('H:i') }}</small>
                            </td>
                            <td>
                                <strong>{{ $bimbingan->mahasiswa->name }}</strong><br>
                                <small class="text-muted">{{ $bimbingan->mahasiswa->nim_nip }}</small>
                            </td>
                            <td>{{ Str::limit($bimbingan->judul, 40) }}</td>
                            <td>
                                <span class="badge {{ $bimbingan->fase == 'sempro' ? 'bg-info' : 'bg-primary' }}">
                                    {{ strtoupper($bimbingan->fase) }}
                                </span>
                            </td>
                            <td>
                                <span class="{{ $bimbingan->getStatusBadge() }}">
                                    {{ $bimbingan->getStatusText() }}
                                </span>
                                @if($bimbingan->percentage)
                                    <br><small class="text-success fw-bold">
                                        <i class="bi bi-star-fill"></i> {{ number_format($bimbingan->percentage, 1) }}%
                                    </small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dosen.bimbingan.review-new', $bimbingan->id) }}"
                                   class="btn btn-sm {{ $bimbingan->status == 'pending' ? 'btn-unej-primary' : 'btn-outline-secondary' }}">
                                    <i class="bi bi-eye"></i> {{ $bimbingan->status == 'pending' ? 'Review' : 'Lihat' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">Belum ada riwayat bimbingan berkas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection