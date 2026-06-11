@extends('layouts.app')

@section('title', 'Pengajuan Bimbingan Baru - SIM-TA UNEJ')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">
        <i class="bi bi-file-earmark-arrow-up text-primary me-2"></i> Pengajuan Bimbingan Baru
    </h2>
    <p class="text-secondary mb-0">Silakan lengkapi formulir di bawah ini untuk mengunggah berkas bimbingan Anda.</p>
</div>

<div class="card border-0 shadow-sm mx-auto" style="border-radius: 14px; max-width: 800px;">
    <div class="card-header bg-white d-flex align-items-center gap-2 py-3 border-0" style="border-radius: 14px 14px 0 0;">
        <i class="bi bi-pencil-square text-primary fs-5"></i>
        <h5 class="mb-0 fw-bold text-dark">Formulir Upload Berkas</h5>
    </div>
    
    <div class="card-body p-4">
        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="background-color: #FEF2F2; color: #991B1B; border-radius: 10px;">
                <div class="d-flex align-items-center mb-2 fw-bold">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i> Periksa kembali isian Anda:
                </div>
                <ul class="list-unstyled ps-4 mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-dot me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.bimbingan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- PILIH DOSEN PEMBIMBING --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-dark">
                    <i class="bi bi-person-badge text-secondary me-1"></i> Pilih Dosen Pembimbing
                </label>
                <select name="bimbingan_id" class="form-select px-3 py-2.5" style="border-radius: 10px; border-color: #E2E8F0;" required>
                    <option value="" selected disabled>-- Pilih Dosen Pembimbing --</option>
                    @foreach ($dosenPembimbing as $dosen)
                        <option value="{{ $dosen->pivot->id }}">
                            {{ $dosen->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FILE TYPE --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-dark">
                    <i class="bi bi-tags text-secondary me-1"></i> Jenis File / Sub-Bab
                </label>
                <input type="text" name="file_type" class="form-control px-3 py-2.5" 
                       placeholder="contoh: Proposal, Revisi Bab 2, Catatan Tambahan" 
                       style="border-radius: 10px; border-color: #E2E8F0;" required>
            </div>

            {{-- FILE UPLOAD --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-dark">
                    <i class="bi bi-cloud-upload text-secondary me-1"></i> Unggah File Dokumen
                </label>
                <input type="file" name="file" class="form-control px-3 py-2.5" 
                       accept=".pdf,.doc,.docx,.odt,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.oasis.opendocument.text" 
                       style="border-radius: 10px; border-color: #E2E8F0;" required>
                <div class="form-text text-muted small mt-2 d-flex align-items-center gap-1">
                    <i class="bi bi-info-circle"></i> Format: PDF, DOC, DOCX, atau ODT | Ukuran Maksimal: 10MB
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">
                    <i class="bi bi-chat-left-text text-secondary me-1"></i> Deskripsi / Catatan (Opsional)
                </label>
                <textarea name="description" class="form-control p-3" rows="4"
                          placeholder="Tambahkan catatan singkat mengenai progres atau revisi yang diserahkan kepada dosen..." 
                          style="border-radius: 10px; border-color: #E2E8F0; resize: none;"></textarea>
            </div>

            {{-- BUTTONS --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-light px-4 py-2 fw-semibold text-secondary" style="border-radius: 10px;">
                    Batal
                </a>
                <button type="submit" class="btn text-white px-4 py-2 shadow-sm" style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%); border: none; border-radius: 10px; font-weight: 600;">
                    <i class="bi bi-send-fill me-2"></i> Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>