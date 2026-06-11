@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-muted"><i class="bi bi-cloud-arrow-up"></i> Upload File Bimbingan</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('mahasiswa.bimbingan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- 1. FITUR PILIHAN DOSEN PEMBIMBING DENGAN TOMBOL X THEME BLUE --}}
                <div class="mb-3">
                    <label for="dosen_id" class="form-label fw-bold">Dosen Pembimbing <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="dosen_id" id="dosen_id" class="form-select @error('dosen_id') is-invalid @enderror" required>
                            <option value="" selected disabled>-- Pilih Dosen Pembimbing --</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->name }} @if($dosen->nim_nip) (NIP: {{ $dosen->nim_nip }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                type="button" 
                                onclick="document.getElementById('dosen_id').value = '';" 
                                title="Kosongkan Pilihan"
                                style="border-color: #ced4da; color: #008bb9; padding-left: 15px; padding-right: 15px; transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='#008bb9'; this.style.color='#ffffff'; this.style.borderColor='#008bb9';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#008bb9'; this.style.borderColor='#ced4da';">
                            <i class="bi bi-x-lg" style="-webkit-text-stroke: 1.5px; font-weight: 900;"></i>
                        </button>
                    </div>
                    @error('dosen_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Topik / Judul Bimbingan --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Topik / Judul Bimbingan <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" 
                           value="{{ old('judul') }}" placeholder="Contoh: Sistem Informasi Manajemen Inventori" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi / Catatan --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi / Catatan</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="4" placeholder="Jelaskan ringkas tentang bimbingan ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 2. FITUR TIPE FILE (FASE) DENGAN TOMBOL X THEME BLUE --}}
                <div class="mb-3">
                    <label for="fase" class="form-label fw-bold">Tipe File <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="fase" id="fase" class="form-select @error('fase') is-invalid @enderror" required>
                            <option value="" selected disabled>-- Pilih Tipe --</option>
                            <option value="proposal" {{ old('fase') == 'proposal' ? 'selected' : '' }}>Proposal (Sempro)</option>
                            <option value="sempro" {{ old('fase') == 'sempro' ? 'selected' : '' }}>Seminar Proposal (Sempro)</option>
                            <option value="sidang" {{ old('fase') == 'sidang' ? 'selected' : '' }}>Sidang</option>
                        </select>
                        <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                type="button" 
                                onclick="document.getElementById('fase').value = '';" 
                                title="Kosongkan Tipe File"
                                style="border-color: #ced4da; color: #008bb9; padding-left: 15px; padding-right: 15px; transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='#008bb9'; this.style.color='#ffffff'; this.style.borderColor='#008bb9';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#008bb9'; this.style.borderColor='#ced4da';">
                            <i class="bi bi-x-lg" style="-webkit-text-stroke: 1.5px; font-weight: 900;"></i>
                        </button>
                    </div>
                    @error('fase')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 3. FITUR FILE DOKUMEN DENGAN TOMBOL X THEME BLUE --}}
                <div class="mb-4">
                    <label for="file" class="form-label fw-bold">File Dokumen <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" 
                               accept=".pdf,.doc,.docx,.odt" required>
                        <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                type="button" 
                                onclick="document.getElementById('file').value = '';" 
                                title="Batalkan File"
                                style="border-color: #ced4da; color: #008bb9; padding-left: 15px; padding-right: 15px; transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='#008bb9'; this.style.color='#ffffff'; this.style.borderColor='#008bb9';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#008bb9'; this.style.borderColor='#ced4da';">
                            <i class="bi bi-x-lg" style="-webkit-text-stroke: 1.5px; font-weight: 900;"></i>
                        </button>
                    </div>
                    <small class="form-text text-muted d-block mt-2">Format: PDF, DOC, DOCX, atau ODT (OpenDocument Text) | Ukuran Maksimal: 10MB</small>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-info text-white px-4" style="background-color: #008bb9; border-color: #008bb9;">
                        <i class="bi bi-cloud-arrow-up"></i> Upload Bimbingan
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection