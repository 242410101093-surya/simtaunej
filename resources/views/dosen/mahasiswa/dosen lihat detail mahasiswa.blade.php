{{-- File: resources/views/dosen/mahasiswa/dosen lihat detail mahasiswa.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="row">
    <!-- Info Mahasiswa -->
    <div class="col-md-4">
        <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 py-3" style="border-radius: 16px 16px 0 0;">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-person-circle text-primary me-2"></i> Profil Mahasiswa
                </h5>
            </div>
            <div class="card-body text-center pt-2">
                <div class="d-inline-flex align-items-center justify-content-center text-white shadow-sm mb-3" 
                     style="width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, #02023e 0%, #005f92 100%);">
                    <i class="bi bi-person-fill" style="font-size: 2.8rem;"></i>
                </div>
                <h4 class="mt-2 fw-bold text-dark">{{ $mahasiswa->name }}</h4>
                <p class="text-secondary small mb-1 fw-semibold">NIM: {{ $mahasiswa->nim_nip ?? '-' }}</p>
                <p class="text-muted small mb-4">
                    <i class="bi bi-envelope-fill me-1 opacity-75"></i> {{ $mahasiswa->email }}
                </p>

                <!-- Status Progres -->
                <div class="p-3 mb-4 text-center border-0" 
                     style="border-radius: 12px !important; {{ $mahasiswa->statusMahasiswa?->layak_sidang ? 'background-color: #ecfdf5; color: #047857; border: 1px solid #d1fae5 !important;' : 'background-color: #fffbef; color: #b45309; border: 1px solid #fef3c7 !important;' }}">
                    <span class="small fw-bold text-uppercase d-block mb-1 opacity-75" style="font-size: 0.75rem; letter-spacing: 0.05em;">Status Akademik</span>
                    <span class="fs-6 fw-bold">{{ $mahasiswa->statusMahasiswa?->getStatusText() ?? 'Bimbingan Sempro' }}</span>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4 text-start">
                    <label class="small fw-bold text-secondary mb-2 d-flex justify-content-between">
                        <span><i class="bi bi-bar-chart-fill text-primary me-1"></i> Progres TA</span>
                        <span class="text-primary">{{ $mahasiswa->statusMahasiswa?->getProgresPercentage() ?? 0 }}%</span>
                    </label>
                    <div class="progress" style="height: 16px; border-radius: 8px; background-color: #f1f5f9;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                             style="width: {{ $mahasiswa->statusMahasiswa?->getProgresPercentage() ?? 0 }}%; background: linear-gradient(135deg, #2563eb 0%, #10b981 100%); border-radius: 8px;"
                             role="progressbar">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    @if(!$mahasiswa->statusMahasiswa || !$mahasiswa->statusMahasiswa->layak_sempro)
                        <form action="{{ route('dosen.approve.sempro', $mahasiswa->id) }}" method="POST">
                            @csrf
                            <button type="button"
                                    class="btn btn-warning w-100 btn-confirm fw-bold text-dark px-3 py-2.5"
                                    style="border-radius: 10px;"
                                    data-message="Yakin menyetujui mahasiswa ini layak sempro?"
                                    data-title="Persetujuan Layak Sempro"
                                    data-confirm-text="Setujui Sempro">
                                <i class="bi bi-check-circle me-1"></i> Setujui Layak Sempro
                            </button>
                        </form>
                    @endif

                    @if($mahasiswa->statusMahasiswa?->layak_sempro && !$mahasiswa->statusMahasiswa?->layak_sidang)
                        <form action="{{ route('dosen.approve.sidang', $mahasiswa->id) }}" method="POST">
                            @csrf
                            <button type="button"
                                    class="btn btn-success w-100 btn-confirm fw-bold text-white px-3 py-2.5"
                                    style="border-radius: 10px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;"
                                    data-message="Yakin menyetujui mahasiswa ini layak sidang?"
                                    data-title="Persetujuan Layak Sidang"
                                    data-confirm-text="Setujui Sidang">
                                <i class="bi bi-check-circle-fill me-1"></i> Setujui Layak Sidang
                            </button>
                        </form>
                    @endif

                    @if($mahasiswa->statusMahasiswa?->layak_sidang)
                        <div class="alert alert-success border-0 mb-0 shadow-sm d-flex align-items-center justify-content-center gap-2 p-3" 
                             style="background-color: #ecfdf5; color: #047857; border-radius: 12px;">
                            <i class="bi bi-trophy-fill fs-5"></i>
                            <strong class="small">Mahasiswa Layak Sidang!</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Bimbingan -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history"></i> Riwayat Bimbingan</span>
                <span class="badge bg-secondary">Total: {{ $bimbingan->count() }}</span>
            </div>
            <div class="card-body">
                @forelse($bimbingan as $b)
                    <div class="card mb-3 border-start border-4 {{ $b->status == 'approved' ? 'border-success' : ($b->status == 'revisi' ? 'border-danger' : 'border-warning') }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $b->judul }}</h6>
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-calendar"></i> {{ $b->tanggal_upload->format('d F Y, H:i') }}
                                    </p>

                                    @if($b->deskripsi)
                                        <p class="mb-2"><strong>Deskripsi:</strong> {{ $b->deskripsi }}</p>
                                    @endif

                                    @if($b->komentar_dosen)
                                        <div class="alert alert-light mb-2">
                                            <strong><i class="bi bi-chat-left-text"></i> Komentar Dosen:</strong>
                                            <p class="mb-0">{{ $b->komentar_dosen }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="ms-3 text-end">
                                    <span class="{{ $b->getStatusBadge() }} mb-2 d-inline-block">
                                        {{ $b->getStatusText() }}
                                    </span>
                                    <br>
                                    <span class="badge {{ $b->fase == 'sempro' ? 'bg-info' : 'bg-primary' }}">
                                        {{ strtoupper($b->fase) }}
                                    </span>
                                    @if($b->percentage)
                                        <br>
                                        <span class="badge bg-secondary mt-1">{{ $b->percentage }}%</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('dosen.bimbingan.file.view', ['id' => $b->id, 'download' => 1]) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="bi bi-download"></i> Unduh
                                </a>

                                @if($b->status == 'pending')
                                    <a href="{{ route('dosen.bimbingan.review', $b->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Review
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-3">Belum ada riwayat bimbingan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
