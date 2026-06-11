@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm mx-auto" style="max-width: 1000px; border-radius: 8px;">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 text-muted"><i class="bi bi-cloud-arrow-up"></i> Upload File Bimbingan</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('mahasiswa.bimbingan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- FITUR PILIHAN DOSEN PEMBIMBING --}}
                <div class="mb-3">
                    <label for="dosen_id" class="form-label">Dosen Pembimbing <span class="text-danger">*</span></label>
                    <select name="dosen_id" id="dosen_id" class="form-select" required>
                        <option value="" selected disabled>-- Pilih Dosen Pembimbing --</option>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Topik / Judul Bimbingan --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Topik / Judul Bimbingan <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Contoh: Sistem Informasi Manajemen Inventori" required>
                </div>

                {{-- Deskripsi / Catatan --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi / Catatan</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Jelaskan ringkas tentang bimbingan ini..."></textarea>
                </div>

                {{-- Tipe File (Fase) --}}
                <div class="mb-3">
                    <label for="fase" class="form-label">Tipe File <span class="text-danger">*</span></label>
                    <select name="fase" id="fase" class="form-select" required>
                        <option value="" selected disabled>-- Pilih Tipe --</option>
                        <option value="proposal">Proposal (Sempro)</option>
                        <option value="sempro">Seminar Proposal (Sempro)</option>
                        <option value="sidang">Sidang</option>
                    </select>
                </div>

                {{-- File Dokumen --}}
                <div class="mb-4">
                    <label for="file" class="form-label">File Dokumen <span class="text-danger">*</span></label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.odt" required>
                    <small class="form-text text-muted d-block mt-2">Format: PDF, DOC, DOCX, atau ODT | Ukuran Maksimal: 10MB</small>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-info text-white px-4" style="background-color: #008bb9; border-color: #008bb9;">
                        Upload Bimbingan
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection