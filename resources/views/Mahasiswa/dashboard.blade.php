@extends('layouts.app')

@section('title', 'DASHBOARD MAHASISWA - SIM-TA UNEJ')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold text-dark mb-1">
            <i class="bi bi-person-workspace text-primary me-2"></i> DASHBOARD MAHASISWA
        </h2>
        <p class="text-secondary mb-0">Selamat datang kembali, <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span></p>
    </div>
    <button type="button" class="btn btn-unej-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadBimbinganModal" style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%); color: white; border: none; border-radius: 10px; font-weight: 600; padding: 8px 20px;">
        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload Bimbingan Baru
    </button>
</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

<div class="card mb-4 border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white d-flex align-items-center gap-2 py-3 border-0" style="border-radius: 14px 14px 0 0;">
        <i class="bi bi-graph-up-arrow text-primary fs-5"></i>
        <h5 class="mb-0 fw-bold text-dark">Progres Bimbingan Tugas Akhir</h5>
    </div>
    <div class="card-body p-4">
        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-6">
                <span class="text-muted small uppercase fw-bold d-block mb-1">Status Saat Ini</span>
                <h3 class="mb-0 fw-bold text-dark">
                    <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 fs-5 rounded-3">
                        {{ method_exists($status, 'getStatusText') ? $status->getStatusText() : 'Belum Bimbingan' }}
                    </span>
                </h3>
            </div>
            <div class="col-sm-6 text-sm-end">
                <div class="display-5 fw-bold text-primary m-0" style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    {{ method_exists($status, 'getProgresPercentage') ? $status->getProgresPercentage() : 0 }}%
                </div>
                <small class="text-secondary fw-medium">Progres Keseluruhan Kelayakan TA</small>
            </div>
        </div>

        <div class="mb-4">
            <div class="progress" style="height: 24px; border-radius: 8px; background-color: #E2E8F0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: {{ method_exists($status, 'getProgresPercentage') ? $status->getProgresPercentage() : 0 }}%; background: linear-gradient(135deg, #2563EB 0%, #60A5FA 100%);"
                     aria-valuenow="{{ method_exists($status, 'getProgresPercentage') ? $status->getProgresPercentage() : 0 }}"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    <span class="fw-bold small">{{ method_exists($status, 'getProgresPercentage') ? $status->getProgresPercentage() : 0 }}%</span>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <div class="card h-100 shadow-none border-2" 
                     style="border-radius: 12px; {{ !($status->layak_sempro ?? false) ? 'background: linear-gradient(135deg, #ffffff 0%, #EFF6FF 100%); border-color: #BFDBFE;' : 'background: #ffffff; border-color: #E2E8F0;' }}">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-1-circle-fill {{ !($status->layak_sempro ?? false) ? 'text-primary' : 'text-muted' }}" style="font-size: 2.5rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Bimbingan Sempro</h6>
                        <p class="small text-secondary mb-3">Upload & revisi draft dokumen proposal</p>
                        @if(!($status->layak_sempro ?? false))
                            <span class="badge bg-primary-subtle text-primary px-3 py-1.5 rounded-pill fw-semibold">
                                <i class="bi bi-play-circle-fill me-1"></i> Aktif
                            </span>
                        @else
                            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                <i class="bi bi-check-circle-fill me-1"></i> Selesai
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-none border-2"
                     style="border-radius: 12px; {{ ($status->layak_sempro ?? false) ? 'background: linear-gradient(135deg, #ffffff 0%, #ECFDF5 100%); border-color: #A7F3D0;' : 'background: #ffffff; border-color: #E2E8F0;' }}">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-2-circle-fill {{ ($status->layak_sempro ?? false) ? 'text-success' : 'text-muted' }}" style="font-size: 2.5rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Layak Sempro</h6>
                        <p class="small text-secondary mb-3">Disetujui dosen untuk seminar proposal</p>
                        @if($status->layak_sempro ?? false)
                            @if(!($status->layak_sidang ?? false))
                                <span class="badge bg-primary-subtle text-primary px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-play-circle-fill me-1"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                </span>
                            @endif
                        @else
                            <span class="badge bg-secondary-subtle text-muted px-3 py-1.5 rounded-pill fw-medium">Belum Dicapai</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-none border-2"
                     style="border-radius: 12px; {{ ($status->layak_sidang ?? false) ? 'background: linear-gradient(135deg, #ffffff 0%, #F0FDF4 100%); border-color: #86EFAC;' : 'background: #ffffff; border-color: #E2E8F0;' }}">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-3-circle-fill {{ ($status->layak_sidang ?? false) ? 'text-success' : 'text-muted' }}" style="font-size: 2.5rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">Layak Sidang</h6>
                        <p class="small text-secondary mb-3">Draft TA final disetujui untuk sidang skripsi</p>
                        @if($status->layak_sidang ?? false)
                            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                <i class="bi bi-trophy-fill me-1"></i> Selesai
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-muted px-3 py-1.5 rounded-pill fw-medium">Belum Dicapai</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white d-flex align-items-center gap-2 py-3 border-0" style="border-radius: 14px 14px 0 0;">
        <i class="bi bi-calendar2-week text-primary fs-5"></i>
        <h5 class="mb-0 fw-bold text-dark">Jadwal Pertemuan Bimbingan</h5>
    </div>
    <div class="card-body p-4">


        @if($upcomingAppointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0" style="border-radius: 10px; overflow: hidden;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 border-bottom-0">Dosen Pembimbing</th>
                            <th class="border-bottom-0">Jadwal Pertemuan</th>
                            <th class="text-end pe-4 border-bottom-0">Status Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingAppointments as $appointment)
                            @php
                                $isToday = \Carbon\Carbon::parse($appointment->scheduled_date)->isToday();
                                $dateOnly = \Carbon\Carbon::parse($appointment->scheduled_date)->toDateString();
                                $jadwalTime = \Carbon\Carbon::parse($dateOnly . ' ' . $appointment->scheduled_time);
                                $minsLeft = \Carbon\Carbon::now()->diffInMinutes($jadwalTime, false);
                            @endphp
                            <tr>
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: {{ ($isToday && $minsLeft <= 60 && $minsLeft > 0) ? '#FEF3C7' : '#EFF6FF' }};">
                                            <i class="bi bi-person-fill fs-5 {{ ($isToday && $minsLeft <= 60 && $minsLeft > 0) ? 'text-warning' : 'text-primary' }}"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;">{{ $appointment->dosen->name }}</h6>
                                            <span class="small text-muted"><i class="bi bi-chat-text me-1"></i> {{ Str::limit($appointment->notes ?? 'Bimbingan', 30) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;">{{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('d M Y') }}</h6>
                                    <span class="small text-muted"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }} WIB</span>
                                </td>
                                <td class="text-end pe-4">
                                    @if($isToday && $minsLeft <= 60 && $minsLeft > 0)
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-alarm me-1"></i> Segera ({{ $minsLeft }} mnt)</span>
                                    @elseif($isToday)
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">Hari Ini</span>
                                    @else
                                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Mendatang</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('mahasiswa.appointments.index') }}" class="btn btn-outline-primary btn-sm px-4 py-2" style="border-radius: 8px;">
                    <i class="bi bi-calendar-check me-1"></i> Lihat Semua Jadwal Saya
                </a>
            </div>
        @else
            <div class="text-center py-4">
                <div class="p-3 d-inline-block rounded-circle bg-light mb-3">
                    <i class="bi bi-calendar-plus text-muted fs-2"></i>
                </div>
                <h6 class="fw-bold text-dark">Belum ada jadwal tatap muka mendatang</h6>
                <p class="small text-muted mb-3 mx-auto" style="max-width: 440px;">Ajukan waktu temu langsung atau bimbingan online terjadwal dengan dosen pembimbing utama Anda terlebih dahulu.</p>
                
                <a href="{{ route('mahasiswa.appointments.index') }}" class="btn text-white btn-sm px-4 py-2 shadow-sm" style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%); border: none; border-radius: 10px; font-weight: 500;">
                    <i class="bi bi-calendar-plus me-2"></i> Booking Jadwal Sekarang
                </a>
            </div>
        @endif
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border border-2 shadow-sm h-100 stat-card" id="cardTotalBerkas" 
             style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #EFF6FF 100%); border-left: 5px solid #2563EB !important; border-color: transparent; cursor: pointer; transition: all 0.3s ease;">
            <div class="card-body d-flex align-items-center p-4">
                <div class="p-3 bg-white shadow-sm rounded-3 text-primary me-4">
                    <i class="bi bi-file-earmark-arrow-up fs-2"></i>
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-0">{{ $totalBimbingan ?? 0 }}</h2>
                    <p class="text-secondary small mb-0 fw-medium">Total Berkas Upload Bimbingan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border border-2 shadow-sm h-100 stat-card" id="cardBerkasApproved" 
             style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #ECFDF5 100%); border-left: 5px solid #10B981 !important; border-color: transparent; cursor: pointer; transition: all 0.3s ease;">
            <div class="card-body d-flex align-items-center p-4">
                <div class="p-3 bg-white shadow-sm rounded-3 text-success me-4">
                    <i class="bi bi-file-earmark-check fs-2"></i>
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-0">{{ $bimbinganApproved ?? 0 }}</h2>
                    <p class="text-secondary small mb-0 fw-medium">Berkas Bimbingan Telah Disetujui</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white d-flex align-items-center gap-2 py-3 border-0" style="border-radius: 14px 14px 0 0;">
        <i class="bi bi-person-lines-fill text-primary fs-5"></i>
        <h5 class="mb-0 fw-bold text-dark">Tim Dosen Pembimbing Anda</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @if(isset($dosenPembimbing) && count($dosenPembimbing) > 0)
                @foreach($dosenPembimbing as $dosen)
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #F8FAFC 100%); border-left: 4px solid #0F172A !important;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" 
                                             style="width: 50px; height: 50px; background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);">
                                            <i class="bi bi-person-fill fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="mb-1 fw-bold text-dark text-truncate">{{ $dosen->name ?? 'Dosen' }}</h6>
                                        <p class="mb-0 text-muted small text-truncate">
                                            <i class="bi bi-envelope-fill me-1 opacity-50"></i>{{ $dosen->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-warning border-0 m-0 shadow-sm" style="background-color: #FFFBEB; color: #92400E; border-radius: 10px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Tim Pembimbing Skripsi belum ditetapkan.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-0" style="border-radius: 14px 14px 0 0;">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-clock-history text-primary fs-5"></i>
            <h5 class="mb-0 fw-bold text-dark">Riwayat Berkas & Log Bimbingan</h5>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="background-color: #F8FAFC; color: #475569;">No</th>
                        <th style="background-color: #F8FAFC; color: #475569;">Judul/Sub-Bab Dokumen</th>
                        <th style="background-color: #F8FAFC; color: #475569;">Dosen Penelaah</th>
                        <th class="pe-4" style="background-color: #F8FAFC; color: #475569;">Status</th>
                    </tr>
                </thead>
                <tbody id="bimbinganTableBody">
                    @if(isset($riwayatBimbingan) && count($riwayatBimbingan) > 0)
                        @foreach($riwayatBimbingan as $index => $bimbingan)
                            <tr class="bimbingan-row" data-status="{{ strtolower($bimbingan->status ?? 'pending') }}">
                                <td class="ps-4 text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $bimbingan->judul }}</td>
                                <td class="text-secondary small">{{ $bimbingan->dosen->name ?? 'Belum Ditentukan' }}</td>
                                <td class="pe-4">
                                    @php
                                        $badgeStyle = match($bimbingan->status ?? 'pending') {
                                            'approved' => 'background: linear-gradient(135deg, #10B981 0%, #059669 100%);',
                                            'revisi'   => 'background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);',
                                            default    => 'background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);',
                                        };
                                    @endphp
                                    <span class="badge text-white px-3 py-1.5 small rounded-pill shadow-sm" 
                                          style="{{ $badgeStyle }} font-weight: 600;">
                                        <i class="bi bi-patch-check-fill me-1"></i> {{ ucfirst($bimbingan->status ?? 'pending') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="p-3 d-inline-block rounded-circle bg-light mb-2">
                                    <i class="bi bi-folder-x text-muted fs-2"></i>
                                </div>
                                <h6 class="text-muted fw-bold mb-0">Belum ada riwayat bimbingan</h6>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Drag and Drop Zone inside Modal */
    .modal-file-drop-area {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 30px 15px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        text-align: center;
    }
    .modal-file-drop-area:hover, .modal-file-drop-area.dragover {
        border-color: #005f92;
        background-color: #f1f5f9;
    }
    .modal-file-drop-icon {
        font-size: 2.2rem;
        color: #005f92;
        margin-bottom: 8px;
        transition: transform 0.2s ease;
    }
    .modal-file-drop-area:hover .modal-file-drop-icon {
        transform: translateY(-3px);
    }
    .modal-file-drop-message {
        font-size: 0.9rem;
        color: #334155;
        font-weight: 600;
    }
    .modal-file-drop-hint {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 4px;
    }
    .modal-file-name-preview {
        font-size: 0.85rem;
        font-weight: 600;
        color: #0f172a;
        background-color: #e0f2fe;
        padding: 5px 10px;
        border-radius: 8px;
        margin-top: 8px;
        display: inline-block;
        border: 1px solid #bae6fd;
    }
    .modal-custom-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }
    .modal-custom-header {
        background: linear-gradient(135deg, #02023e 0%, #005f92 100%);
        color: white;
        padding: 20px 24px;
        border-bottom: none;
    }
    .modal-custom-header .btn-close {
        filter: invert(1) grayscale(1) brightness(2);
    }
</style>
@endpush

<!-- Modal Upload Bimbingan Baru -->
<div class="modal fade" id="uploadBimbinganModal" tabindex="-1" aria-labelledby="uploadBimbinganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-custom-content shadow-lg">
            <div class="modal-header modal-custom-header d-flex align-items-center">
                <i class="bi bi-cloud-arrow-up-fill fs-5 me-2"></i>
                <h5 class="modal-title fw-bold" id="uploadBimbinganModalLabel">Upload Bimbingan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mahasiswa.bimbingan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    {{-- 1. Pilihan Dosen Pembimbing --}}
                    <div class="mb-4">
                        <label for="modal_dosen_id" class="form-label fw-bold">Dosen Pembimbing <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge-fill text-primary"></i></span>
                            <select name="dosen_id" id="modal_dosen_id" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Dosen Pembimbing --</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 2. Topik / Judul Bimbingan --}}
                    <div class="mb-4">
                        <label for="modal_judul" class="form-label fw-bold">Topik / Judul Bimbingan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-chat-left-quote-fill text-primary"></i></span>
                            <input type="text" name="judul" id="modal_judul" class="form-control" placeholder="Contoh: Sistem Informasi Manajemen Inventori" required>
                        </div>
                    </div>

                    {{-- 3. Deskripsi / Catatan --}}
                    <div class="mb-4">
                        <label for="modal_deskripsi" class="form-label fw-bold">Deskripsi / Catatan (Opsional)</label>
                        <textarea name="deskripsi" id="modal_deskripsi" class="form-control" rows="3" placeholder="Jelaskan secara ringkas tentang progres atau revisi..."></textarea>
                    </div>

                    {{-- 4. Tipe File (Fase) --}}
                    <div class="mb-4">
                        <label for="modal_fase" class="form-label fw-bold">Tipe File <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-tags-fill text-primary"></i></span>
                            <select name="fase" id="modal_fase" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Tipe --</option>
                                <option value="proposal">Proposal (Sempro)</option>
                                <option value="sempro">Seminar Proposal (Sempro)</option>
                                <option value="sidang">Sidang</option>
                            </select>
                        </div>
                    </div>

                    {{-- 5. File Dokumen --}}
                    <div class="mb-2">
                        <label class="form-label fw-bold">File Dokumen <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="modal_file" class="d-none" accept=".pdf,.doc,.docx,.odt" required>
                        <div class="modal-file-drop-area" id="modalDropArea">
                            <i class="bi bi-file-earmark-arrow-up modal-file-drop-icon"></i>
                            <span class="modal-file-drop-message">Tarik & lepas file ke sini, atau klik untuk memilih</span>
                            <span class="modal-file-drop-hint">Format: PDF, DOC, DOCX, atau ODT (Maksimal 10MB)</span>
                            <div id="modalFilePreview" class="d-none">
                                <span class="modal-file-name-preview" id="modalFileName"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between p-4 bg-light border-top">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">Batal</button>
                    <button type="submit" class="btn text-white px-4 py-2" style="background: linear-gradient(135deg, #005f92 0%, #004b75 100%); border: none; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 95, 146, 0.2);">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload Bimbingan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalDropArea = document.getElementById('modalDropArea');
        const modalFileInput = document.getElementById('modal_file');
        const modalFilePreview = document.getElementById('modalFilePreview');
        const modalFileName = document.getElementById('modalFileName');

        if (modalDropArea && modalFileInput) {
            // Click to upload
            modalDropArea.addEventListener('click', () => modalFileInput.click());

            // Drag and drop events
            ['dragenter', 'dragover'].forEach(eventName => {
                modalDropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    modalDropArea.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                modalDropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    modalDropArea.classList.remove('dragover');
                }, false);
            });

            modalDropArea.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    modalFileInput.files = files;
                    updateModalFilePreview(files[0].name);
                }
            });

            modalFileInput.addEventListener('change', () => {
                if (modalFileInput.files.length > 0) {
                    updateModalFilePreview(modalFileInput.files[0].name);
                }
            });
        }

        function updateModalFilePreview(name) {
            modalFileName.textContent = name;
            modalFilePreview.classList.remove('d-none');
            modalDropArea.querySelector('.modal-file-drop-icon').className = 'bi bi-file-earmark-check-fill modal-file-drop-icon text-success';
            modalDropArea.querySelector('.modal-file-drop-message').textContent = 'File siap diunggah';
        }

        // Stats Cards Clickable Filtering
        const cardTotal = document.getElementById('cardTotalBerkas');
        const cardApproved = document.getElementById('cardBerkasApproved');
        const bimbinganRows = document.querySelectorAll('.bimbingan-row');
        const riwayatCard = document.getElementById('bimbinganTableBody') ? document.getElementById('bimbinganTableBody').closest('.card') : document.querySelector('.table-responsive');

        if (cardTotal && cardApproved) {
            cardTotal.addEventListener('click', function() {
                // Reset card styling
                cardApproved.style.transform = '';
                cardApproved.style.boxShadow = '';
                cardApproved.style.borderColor = 'transparent';
                
                // Set active card styling
                cardTotal.style.transform = 'translateY(-4px)';
                cardTotal.style.boxShadow = '0 12px 20px rgba(37, 99, 235, 0.15)';
                cardTotal.style.borderColor = '#2563EB';

                bimbinganRows.forEach(row => {
                    row.style.display = '';
                });

                if (riwayatCard) {
                    riwayatCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });

            cardApproved.addEventListener('click', function() {
                // Reset card styling
                cardTotal.style.transform = '';
                cardTotal.style.boxShadow = '';
                cardTotal.style.borderColor = 'transparent';

                // Set active card styling
                cardApproved.style.transform = 'translateY(-4px)';
                cardApproved.style.boxShadow = '0 12px 20px rgba(16, 185, 129, 0.15)';
                cardApproved.style.borderColor = '#10B981';

                bimbinganRows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    if (status === 'approved') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (riwayatCard) {
                    riwayatCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }
    });
</script>
@endsection