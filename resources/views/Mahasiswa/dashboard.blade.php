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
    <a href="{{ route('mahasiswa.bimbingan.create') }}" class="btn btn-unej-primary shadow-sm" style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%); color: white; border: none; border-radius: 10px; font-weight: 600; padding: 8px 20px;">
        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload Bimbingan Baru
    </a>
</div>

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
        <div class="text-center py-4">
            <div class="p-3 d-inline-block rounded-circle bg-light mb-3">
                <i class="bi bi-calendar-plus text-muted fs-2"></i>
            </div>
            <h6 class="fw-bold text-dark">Belum ada jadwal tatap muka mendatang</h6>
            <p class="small text-muted mb-3 mx-auto" style="max-width: 440px;">Ajukan waktu temu langsung atau bimbingan online terjadwal dengan dosen pembimbing utama Anda terlebih dahulu.</p>
            
            {{-- REVISI DI SINI: href="#" diganti ke rute appointments index --}}
            <a href="{{ route('mahasiswa.appointments.index') }}" class="btn text-white btn-sm px-4 py-2 shadow-sm" style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%); border: none; border-radius: 10px; font-weight: 500;">
                <i class="bi bi-calendar-plus me-2"></i> Booking Jadwal Sekarang
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #EFF6FF 100%); border-left: 5px solid #2563EB !important;">
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
        <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; background: linear-gradient(135deg, #ffffff 0%, #ECFDF5 100%); border-left: 5px solid #10B981 !important;">
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
                <tbody>
                    @if(isset($riwayatBimbingan) && count($riwayatBimbingan) > 0)
                        @foreach($riwayatBimbingan as $index => $bimbingan)
                            <tr>
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
@endsection