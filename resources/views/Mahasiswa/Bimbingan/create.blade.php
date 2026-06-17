@extends('layouts.app')

@section('title', 'Upload File Bimbingan - SIM-TA UNEJ')

@push('styles')
<style>
    .upload-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }
    .upload-header {
        background: linear-gradient(135deg, #02023e 0%, #005f92 100%);
        color: white;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 24px;
    }
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #005f92;
        box-shadow: 0 0 0 4px rgba(0, 95, 146, 0.1);
        background-color: #f8fafc;
    }
    .input-group-text {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-right: none;
        color: #005f92;
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        padding-left: 16px;
        padding-right: 16px;
    }
    .input-group > .form-control, .input-group > .form-select {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
    
    /* Drag and Drop Zone */
    .file-drop-area {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 40px 20px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        text-align: center;
    }
    .file-drop-area:hover, .file-drop-area.dragover {
        border-color: #005f92;
        background-color: #f1f5f9;
    }
    .file-drop-icon {
        font-size: 2.5rem;
        color: #005f92;
        margin-bottom: 12px;
        transition: transform 0.2s ease;
    }
    .file-drop-area:hover .file-drop-icon {
        transform: translateY(-4px);
    }
    .file-drop-message {
        font-size: 0.95rem;
        color: #334155;
        font-weight: 600;
    }
    .file-drop-hint {
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 6px;
    }
    .file-name-preview {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        background-color: #e0f2fe;
        padding: 6px 12px;
        border-radius: 8px;
        margin-top: 10px;
        display: inline-block;
        border: 1px solid #bae6fd;
    }

    .btn-submit {
        background: linear-gradient(135deg, #005f92 0%, #004b75 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 95, 146, 0.2);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 95, 146, 0.3);
        color: white;
    }
    .btn-back {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        background-color: #e2e8f0;
        color: #1e293b;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card upload-card mx-auto" style="max-width: 800px;">
        <div class="upload-header d-flex align-items-center gap-3">
            <div class="bg-white bg-opacity-20 p-2 rounded-3">
                <i class="bi bi-cloud-arrow-up fs-4 text-white"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold">{{ isset($bimbinganModel) ? 'Upload Revisi Bimbingan' : 'Upload File Bimbingan' }}</h5>
                <p class="mb-0 text-white-50 small">
                    {{ isset($bimbinganModel) ? 'Unggah draf revisi dokumen bimbingan Anda untuk ditinjau oleh dosen.' : 'Unggah draf atau revisi dokumen Anda untuk ditinjau oleh dosen.' }}
                </p>
            </div>
        </div>
        
        <div class="card-body p-4 p-md-5">
            @if(isset($bimbinganModel))
                <form action="{{ route('mahasiswa.uploads.store', $bimbinganModel->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @else
                <form action="{{ route('mahasiswa.bimbingan.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @endif
                @csrf

                @if(!isset($bimbinganModel))
                    {{-- FITUR PILIHAN DOSEN PEMBIMBING --}}
                    <div class="mb-4">
                        <label for="dosen_id" class="form-label">Dosen Pembimbing <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                            <select name="dosen_id" id="dosen_id" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Dosen Pembimbing --</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                {{-- Topik / Judul Bimbingan --}}
                <div class="mb-4">
                    <label for="judul" class="form-label">Topik / Judul Bimbingan <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-chat-left-quote-fill"></i></span>
                        <input type="text" name="judul" id="judul" class="form-control" 
                               placeholder="Contoh: Sistem Informasi Manajemen Inventori" 
                               value="{{ isset($bimbinganModel) ? $bimbinganModel->judul : old('judul') }}"
                               required>
                    </div>
                </div>

                {{-- Deskripsi / Catatan --}}
                <div class="mb-4">
                    <label for="deskripsi" class="form-label">Deskripsi / Catatan (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Jelaskan secara ringkas tentang progres atau revisi pada file ini..."></textarea>
                </div>

                @if(!isset($bimbinganModel))
                    {{-- Tipe File (Fase) --}}
                    <div class="mb-4">
                        <label for="fase" class="form-label">Tipe File <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tags-fill"></i></span>
                            <select name="fase" id="fase" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Tipe --</option>
                                <option value="proposal">Proposal (Sempro)</option>
                                <option value="sempro">Seminar Proposal (Sempro)</option>
                                <option value="sidang">Sidang</option>
                            </select>
                        </div>
                    </div>
                @endif

                {{-- File Dokumen --}}
                <div class="mb-5">
                    <label class="form-label">File Dokumen <span class="text-danger">*</span></label>
                    
                    <input type="file" name="file" id="file" class="d-none" accept=".pdf,.doc,.docx,.odt" required>
                    
                    <div class="file-drop-area" id="dropArea">
                        <i class="bi bi-file-earmark-arrow-up file-drop-icon"></i>
                        <span class="file-drop-message">Tarik & lepas file Anda ke sini, atau klik untuk memilih</span>
                        <span class="file-drop-hint">Format: PDF, DOC, DOCX, atau ODT (Maksimal 10MB)</span>
                        <div id="filePreview" class="d-none">
                            <span class="file-name-preview" id="fileName"></span>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between align-items-center border-top pt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-back">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload Bimbingan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('file');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');

        // Trigger file input click when clicking drop area
        dropArea.addEventListener('click', () => fileInput.click());

        // Drag events
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropArea.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropArea.classList.remove('dragover');
            }, false);
        });

        // Drop event
        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                fileInput.files = files;
                updateFilePreview(files[0].name);
            }
        });

        // Change event
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                updateFilePreview(fileInput.files[0].name);
            }
        });

        function updateFilePreview(name) {
            fileName.textContent = name;
            filePreview.classList.remove('d-none');
            dropArea.querySelector('.file-drop-icon').className = 'bi bi-file-earmark-check-fill file-drop-icon text-success';
            dropArea.querySelector('.file-drop-message').textContent = 'File siap diunggah';
        }
    });
</script>
@endsection