{{-- File: resources/views/admin/periods/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Periode Jadwal')

@section('content')
<style>
    .ui-title { color: #0d1b2a !important; font-weight: 700 !important; letter-spacing: -0.025em; }
    .ui-icon-main { color: #0077b6 !important; }
    .bg-gradient-blue { background: linear-gradient(to right, #03045e, #0077b6) !important; }
    .tab-active-period { background: linear-gradient(to right, #03045e, #0077b6) !important; color: #ffffff !important; border: none !important; box-shadow: 0 4px 12px rgba(3, 4, 94, 0.15); }
    .tab-inactive-period { background-color: rgba(248, 249, 250, 0.6) !important; border: 1px solid rgba(222, 226, 230, 0.8) !important; color: #4a5568 !important; }
    .tab-inactive-period:hover { background-color: #f1f3f5 !important; color: #1a202c !important; }
    .btn-custom-action { border-radius: 0.5rem; padding: 10px 18px; font-weight: 500; transition: all 0.2s ease; }
    
    @media print {
        @page { margin: 15mm; size: A4 portrait; }
        body { 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
            background-color: #fff !important; 
        }
        body * { visibility: hidden; }
        .print-only-header, .print-only-header * { visibility: visible !important; display: block !important; }
        .card, .card * { visibility: visible; }
        .card { position: absolute; left: 0; top: 180px; width: 100%; border: none !important; box-shadow: none !important; }
        .card-header .badge, .btn, td:last-child, th:last-child, .tab-inactive-period, .print-hide { display: none !important; }
        .tab-active-period { display: none !important; }
        .table { border: 1px solid #dee2e6 !important; width: 100% !important; margin-bottom: 1rem !important; color: #000 !important; }
        .table th, .table td { padding: 12px !important; border: 1px solid #dee2e6 !important; color: #000 !important; }
        .table thead th { background-color: #f8f9fa !important; font-weight: bold !important; color: #000 !important; }
        .badge { border: 1px solid #000 !important; }
    }
</style>

<!-- HEADER KHUSUS UNTUK PRINT PDF -->
<div class="print-only-header d-none w-100 text-center mb-4" style="position: absolute; top: 0; left: 0; width: 100%;">
    <div style="border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; position: relative; min-height: 100px;">
        <img src="{{ asset('logo-unej.png') }}" style="width: 90px; height: auto; position: absolute; left: 20px; top: 0;" alt="Logo UNEJ">
        <div style="padding-left: 110px; padding-right: 20px;">
            <h3 class="fw-bold mb-1" style="color: #000 !important; font-size: 24px; letter-spacing: 1px;">UNIVERSITAS JEMBER</h3>
            <h4 class="fw-bold mb-1" style="color: #000 !important; font-size: 20px;">FAKULTAS ILMU KOMPUTER</h4>
            <h5 class="fw-semibold" style="color: #333 !important; font-size: 16px;">SISTEM INFORMASI MANAJEMEN TUGAS AKHIR (SIM-TA)</h5>
        </div>
    </div>
    <h4 class="fw-bold text-uppercase mt-3 mb-2" style="color: #000 !important;">DAFTAR PERIODE JADWAL — <span id="printLabelJenis" style="color: #000 !important;">SEMPRO</span></h4>
    <p class="mb-0 text-dark" style="font-size: 14px;">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
</div>

<div class="mb-4 d-flex align-items-center gap-3">
    <h2>
        <i class="bi bi-calendar-week ui-icon-main me-1"></i> 
        <span class="ui-title">KALENDER TUGAS AKHIR MAHASISWA FASILKOM</span>
    </h2>
</div>

<div class="mb-4 d-flex flex-wrap gap-2">
    <button data-bs-toggle="modal" data-bs-target="#modalCreatePeriod" class="btn text-white bg-gradient-blue shadow-sm d-flex align-items-center gap-2 btn-custom-action">
        <i class="bi bi-plus-lg"></i> <span>Tambah Periode Baru</span>
    </button>
    <button id="btnSinkronisasi" class="btn btn-outline-primary d-flex align-items-center gap-2 btn-custom-action" type="button" title="Refresh data periode dari database">
        <i class="bi bi-arrow-clockwise" id="iconSinkronisasi"></i> <span>Sinkronisasi Jadwal</span>
    </button>
    <button onclick="window.print()" class="btn btn-danger d-flex align-items-center gap-2 btn-custom-action" type="button" title="Download PDF Periode Jadwal">
        <i class="bi bi-file-earmark-pdf-fill"></i> <span>Download PDF</span>
    </button>
</div>

{{-- Tab Filter Kategori --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;" id="printHeaderOnly">
    <div class="card-body p-4 bg-white" style="border-radius: 1rem;">
        <div class="row g-3 text-center">
            <div class="col-md-4">
                <button class="btn w-100 fs-6 fw-semibold tab-active-period py-3 period-tab" data-jenis="Sempro" style="border-radius: 0.75rem;">
                    <i class="bi bi-layout-text-sidebar-reverse me-1"></i> Jadwal Sempro
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn w-100 fs-6 fw-semibold tab-inactive-period py-3 period-tab" data-jenis="Semhas" style="border-radius: 0.75rem;">
                    <i class="bi bi-cpu me-1"></i> Jadwal Semhas
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn w-100 fs-6 fw-semibold tab-inactive-period py-3 period-tab" data-jenis="Sidang Skripsi" style="border-radius: 0.75rem;">
                    <i class="bi bi-code-slash"></i> Jadwal Sidang Skripsi
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3" id="printTableArea">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-semibold text-dark">
            <i class="bi bi-calendar3 text-primary me-1"></i> 
            Daftar Periode Jadwal — <span id="labelJenisAktif" class="text-primary">Sempro</span>
        </div>
        <span class="badge bg-secondary rounded-pill px-3" id="totalPeriodBadge">{{ $periods->count() }} Total Periode</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small fw-bold">
                    <tr>
                        <th style="width: 60px;" class="ps-3">No</th>
                        <th>Nama Kegiatan / Gelombang</th>
                        <th>Kategori</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th style="width: 120px;" class="text-center pe-3 print-hide">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPeriods">
                    @forelse($periods as $index => $prd)
                        <tr class="period-row" data-jenis="{{ $prd->jenis ?? 'Sempro' }}">
                            <td class="ps-3 fw-medium text-secondary row-number">{{ $index + 1 }}</td>
                            <td class="fw-semibold text-dark">{{ $prd->period_name }}</td>
                            <td>
                                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-1">
                                    {{ $prd->jenis ?? 'Sempro' }}
                                </span>
                            </td>
                            <td class="text-secondary">
                                <i class="bi bi-calendar-event me-1"></i> 
                                {{ \Carbon\Carbon::parse($prd->start_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="text-secondary">
                                <i class="bi bi-calendar-check me-1"></i> 
                                {{ \Carbon\Carbon::parse($prd->end_date)->translatedFormat('d F Y') }}
                            </td>
                            <td>
                                @if(isset($prd->is_active) && $prd->is_active == 1)
                                    <span class="badge bg-success rounded-pill px-3 py-1">Aktif</span>
                                @elseif(isset($prd->status) && $prd->status == 'Aktif')
                                    <span class="badge bg-success rounded-pill px-3 py-1">Aktif</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-1">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center pe-3 print-hide">
                                <div class="d-flex justify-content-center gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#modalEditPeriod{{ $prd->id }}" class="btn btn-sm btn-outline-primary" title="Edit" style="border-radius: 0.375rem;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('admin.periods.delete', $prd->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-confirm" title="Hapus" style="border-radius: 0.375rem;"
                                                data-message="Apakah Anda yakin ingin menghapus periode '{{ $prd->period_name }}'?" data-title="Hapus Periode Jadwal" data-confirm-text="Ya, Hapus" data-icon="warning">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i> 
                                Belum ada data periode jadwal akademik.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noFilterResult" style="display:none;">
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-search fs-2 d-block mb-2 text-secondary"></i> 
                            Belum ada periode untuk kategori ini.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Removed info text -->

<!-- Modal Create Periode -->
<div class="modal fade" id="modalCreatePeriod" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="modal-header bg-light border-bottom-0" style="border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i> Tambah Periode Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.periods.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Periode <span class="text-danger">*</span></label>
                        <input type="text" name="period_name" class="form-control" placeholder="Contoh: Sempro Gelombang 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori Jadwal <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Sempro">Sempro (Seminar Proposal)</option>
                            <option value="Semhas">Semhas (Seminar Hasil)</option>
                            <option value="Sidang Skripsi">Sidang Skripsi</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 p-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Periode (Rendered Outside Table) -->
@foreach($periods as $prd)
<div class="modal fade" id="modalEditPeriod{{ $prd->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="modal-header bg-light border-bottom-0" style="border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i> Edit Periode Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.periods.update', $prd->id) }}">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3 text-start">
                        <label class="form-label fw-semibold">Nama Periode <span class="text-danger">*</span></label>
                        <input type="text" name="period_name" class="form-control" value="{{ $prd->period_name }}" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-semibold">Kategori Jadwal <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-select" required>
                            <option value="Sempro" {{ $prd->jenis === 'Sempro' ? 'selected' : '' }}>Sempro (Seminar Proposal)</option>
                            <option value="Semhas" {{ $prd->jenis === 'Semhas' ? 'selected' : '' }}>Semhas (Seminar Hasil)</option>
                            <option value="Sidang Skripsi" {{ $prd->jenis === 'Sidang Skripsi' ? 'selected' : '' }}>Sidang Skripsi</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3 text-start">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" value="{{ $prd->start_date }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" value="{{ $prd->end_date }}" required>
                        </div>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ $prd->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $prd->is_active == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 p-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.period-tab');
    const rows = document.querySelectorAll('.period-row');
    const label = document.getElementById('labelJenisAktif');
    const badge = document.getElementById('totalPeriodBadge');
    const noResult = document.getElementById('noFilterResult');
    const emptyRow = document.getElementById('emptyRow');

    function filterByJenis(jenis) {
        label.textContent = jenis;
        let count = 0;

        rows.forEach(row => {
            const rowJenis = row.getAttribute('data-jenis');
            if (rowJenis === jenis) {
                row.style.display = '';
                count++;
                row.querySelector('.row-number').textContent = count;
            } else {
                row.style.display = 'none';
            }
        });

        badge.textContent = count + ' Total Periode';

        if (noResult) noResult.style.display = count === 0 && rows.length > 0 ? '' : 'none';
        if (emptyRow) emptyRow.style.display = rows.length === 0 ? '' : 'none';

        // Update print header label
        const printLabel = document.getElementById('printLabelJenis');
        if (printLabel) printLabel.textContent = jenis;

        tabs.forEach(tab => {
            if (tab.getAttribute('data-jenis') === jenis) {
                tab.classList.remove('tab-inactive-period');
                tab.classList.add('tab-active-period');
            } else {
                tab.classList.remove('tab-active-period');
                tab.classList.add('tab-inactive-period');
            }
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            filterByJenis(this.getAttribute('data-jenis'));
        });
    });

    const btnSink = document.getElementById('btnSinkronisasi');
    const iconSink = document.getElementById('iconSinkronisasi');
    if (btnSink) {
        btnSink.addEventListener('click', function () {
            iconSink.classList.add('spin-anim');
            btnSink.disabled = true;
            if (typeof window.showLoader === 'function') window.showLoader();
            setTimeout(function () {
                window.location.reload();
            }, 600);
        });
    }

    filterByJenis('Sempro');
});
</script>
<style>
@keyframes spin-once { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.spin-anim { animation: spin-once 0.6s linear; }
@media print {
    .sidebar-modern, .navbar, .btn, .print-hide { display: none !important; }
    .content-area { margin-left: 0 !important; width: 100% !important; }
    body { background-color: #fff !important; }
}
</style>
@endpush
@endsection