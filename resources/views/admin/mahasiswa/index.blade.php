{{-- File: resources/views/admin/mahasiswa/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Mahasiswa')

@section('content')
<style>
    .ui-title { color: #0d1b2a !important; font-weight: 700 !important; letter-spacing: -0.025em; }
    .ui-icon-main { color: #0077b6 !important; }
    .bg-gradient-blue { background: linear-gradient(to right, #03045e, #0077b6) !important; }
</style>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2>
        <i class="bi bi-people-fill ui-icon-main me-2"></i>
        <span class="ui-title">KELOLA DATA MAHASISWA</span>
        @if(!empty($adminProdi))
            <span class="badge ms-2 fw-semibold" style="background: linear-gradient(135deg, #03045e, #0077b6); font-size: 0.65rem; border-radius: 8px; padding: 5px 12px; vertical-align: middle;">{{ $adminProdi }}</span>
        @endif
    </h2>
    <a href="{{ route('admin.mahasiswa.create') }}" class="btn text-white bg-gradient-blue shadow-sm d-flex align-items-center gap-2"
       style="border-radius: 0.5rem; padding: 10px 18px; font-weight: 500;">
        <i class="bi bi-person-plus-fill"></i> <span>Tambah Mahasiswa Baru</span>
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div class="fw-semibold text-dark">
            <i class="bi bi-table text-primary me-1"></i> Daftar Mahasiswa Terdaftar
            @if(!empty($adminProdi))
                — <span class="text-primary">{{ $adminProdi }}</span>
            @endif
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="position-relative" style="width: 260px;">
                <span class="position-absolute top-50 translate-middle-y start-0 ps-3 text-muted" style="z-index: 5;">
                    <i class="bi bi-search text-secondary small"></i>
                </span>
                <input type="text" id="searchMhsInput" placeholder="Cari nama atau NIM..."
                       class="form-control" style="padding-left: 2.5rem; border-radius: 0.5rem; height: 38px; font-size: 0.875rem;"
                       autocomplete="off">
            </div>
            <span class="badge bg-secondary rounded-pill px-3">{{ $mahasiswa->total() }} Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tblMahasiswa">
                <thead class="table-light text-secondary small fw-bold">
                    <tr>
                        <th class="ps-3" style="width: 55px;">No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Dosen Pembimbing</th>
                        <th>Status</th>
                        <th style="width: 110px;">Progres</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswa as $index => $mhs)
                        <tr>
                            <td class="ps-3 fw-medium text-secondary">{{ $mahasiswa->firstItem() + $index }}</td>
                            <td><code class="fw-bold text-dark">{{ $mhs->nim_nip ?? '-' }}</code></td>
                            <td class="fw-semibold text-dark">{{ $mhs->name }}</td>
                            <td class="text-muted small">{{ $mhs->email }}</td>
                            <td>
                                @if($mhs->dosenPembimbing->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($mhs->dosenPembimbing as $dosen)
                                            <span class="badge bg-light text-primary border border-primary-subtle px-2 py-1" style="font-size: 0.75rem;">
                                                {{ $dosen->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted small">Belum ditentukan</span>
                                @endif
                            </td>
                            <td>
                                @if($mhs->statusMahasiswa?->layak_sidang)
                                    <span class="badge bg-success rounded-pill px-3">Layak Sidang</span>
                                @elseif($mhs->statusMahasiswa?->layak_sempro)
                                    <span class="badge rounded-pill px-3" style="background: #f59e0b; color: #fff;">Layak Sempro</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">Bimbingan Awal</span>
                                @endif
                            </td>
                            <td>
                                @php $pct = $mhs->statusMahasiswa?->getProgresPercentage() ?? 0; @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 8px; border-radius: 4px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pct }}%;"></div>
                                    </div>
                                    <small class="text-muted fw-semibold" style="width: 35px;">{{ $pct }}%</small>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada data mahasiswa terdaftar.<br>
                                <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary btn-sm mt-3">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Mahasiswa Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $mahasiswa->links() }}
    </div>
</div>

@push('scripts')
<script>
document.getElementById('searchMhsInput').addEventListener('input', function() {
    const keyword = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#tblMahasiswa tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = (!keyword || text.includes(keyword)) ? '' : 'none';
    });
});
</script>
@endpush
@endsection