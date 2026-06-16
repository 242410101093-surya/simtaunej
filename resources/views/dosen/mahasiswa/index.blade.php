@extends('layouts.app')

@section('title', 'Mahasiswa Bimbingan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Mahasiswa Bimbingan Saya</h2>
</div>

<div class="row">
    @forelse($mahasiswa as $mhs)
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; background: #ffffff; padding: 0 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-inline-flex align-items-center justify-content-center text-white shadow-sm" 
                                 style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #02023e 0%, #005f92 100%); flex-shrink: 0;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $mhs->name }}</h5>
                                <p class="text-secondary small mb-0 fw-semibold">NIM: {{ $mhs->nim_nip }}</p>
                            </div>
                        </div>
                        <div>
                            @if($mhs->statusMahasiswa?->layak_sidang)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-trophy-fill me-1"></i> Layak Sidang
                                </span>
                            @elseif($mhs->statusMahasiswa?->layak_sempro)
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Layak Sempro
                                </span>
                            @else
                                <span class="badge bg-light text-secondary border border-secondary-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-hourglass-split me-1"></i> Bimbingan Awal
                                </span>
                            @endif
                        </div>
                    </div>

                    <p class="text-muted small mb-3">
                        <i class="bi bi-envelope-fill me-1 opacity-75"></i> {{ $mhs->email }}
                    </p>

                    <div class="mt-4">
                        @php
                            $progres = $mhs->statusMahasiswa?->getProgresPercentage() ?? 0;
                            if ($progres >= 100) {
                                $barStyle = 'background: linear-gradient(90deg, #10B981 0%, #059669 100%);';
                                $barClass = 'progress-bar progress-bar-striped progress-bar-animated';
                            } elseif ($progres >= 50) {
                                $barStyle = 'background: linear-gradient(90deg, #F59E0B 0%, #10B981 100%);';
                                $barClass = 'progress-bar';
                            } else {
                                $barStyle = 'background: #CBD5E1;';
                                $barClass = 'progress-bar';
                            }
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold text-secondary">Progres Tugas Akhir</span>
                            <span class="small fw-bold text-primary">{{ $progres }}%</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 8px; background-color: #f1f5f9;">
                            <div class="{{ $barClass }}"
                                 role="progressbar"
                                 style="width: {{ $progres }}%; border-radius: 8px; {{ $barStyle }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('dosen.mahasiswa.show', $mhs->id) }}" class="btn btn-unej-primary btn-sm px-4 py-2" style="border-radius: 8px;">
                            <i class="bi bi-eye-fill me-1"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm" style="background-color: #eff6ff; color: #1d4ed8; border-radius: 12px;">
                <i class="bi bi-info-circle-fill me-2"></i>
                Anda belum memiliki mahasiswa bimbingan.
            </div>
        </div>
    @endforelse
</div>
@endsection
