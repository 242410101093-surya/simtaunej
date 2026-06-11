@extends('layouts.app')

@section('title', 'Mahasiswa Bimbingan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Mahasiswa Bimbingan Saya</h2>
</div>

<div class="row">
    @forelse($mahasiswa as $mhs)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">{{ $mhs->name }}</h5>
                            <p class="text-muted mb-2">NIM: {{ $mhs->nim_nip }}</p>
                            <p class="mb-2">
                                <i class="bi bi-envelope"></i> {{ $mhs->email }}
                            </p>
                        </div>
                        <div>
                            @if($mhs->statusMahasiswa?->layak_sidang)
                                <span class="badge bg-success">Layak Sidang</span>
                            @elseif($mhs->statusMahasiswa?->layak_sempro)
                                <span class="badge bg-warning">Layak Sempro</span>
                            @else
                                <span class="badge bg-secondary">Bimbingan Awal</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="small fw-bold">Progres:</label>
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
                        <div class="progress" style="height: 25px; border-radius: 8px; background: #E2E8F0;">
                            <div class="{{ $barClass }}"
                                 role="progressbar"
                                 style="width: {{ $progres }}%; border-radius: 8px; {{ $barStyle }}">
                                {{ $progres }}%
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('dosen.mahasiswa.show', $mhs->id) }}" class="btn btn-unej-primary btn-sm">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                Anda belum memiliki mahasiswa bimbingan.
            </div>
        </div>
    @endforelse
</div>
@endsection
