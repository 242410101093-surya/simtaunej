{{-- File: resources/views/admin/dosen/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Data Dosen')

@section('content')
<style>
    .ui-title {
        color: #0d1b2a !important;
        font-weight: 700 !important;
        letter-spacing: -0.025em;
    }
    .ui-icon-main {
        color: #0077b6 !important;
    }
    
    /* State Tab ACTIVE */
    .tab-active {
        background: linear-gradient(to right, #03045e, #0077b6) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(3, 4, 94, 0.2) !important;
    }
    .tab-active i {
        color: #ffffff !important;
    }

    /* State Tab INACTIVE */
    .tab-inactive {
        background-color: rgba(248, 249, 250, 0.6) !important;
        border: 1px solid rgba(222, 226, 230, 0.8) !important;
        color: #4a5568 !important;
    }
    .tab-inactive:hover {
        background-color: #f1f3f5 !important;
        color: #1a202c !important;
    }
    .tab-inactive i {
        color: #64748b !important;
    }

    .btn-tab-custom {
        padding-top: 0.875rem !important;
        padding-bottom: 0.875rem !important;
        border-radius: 0.75rem !important;
        transition: all 0.2s ease-in-out;
    }
</style>

<div class="mb-4 d-flex align-items-center gap-3">
    <h2>
        <i class="bi bi-person-lines-fill ui-icon-main me-1"></i> 
        <span class="ui-title">DAFTAR DATA DOSEN BIMBINGAN FASILKOM</span>
    </h2>
</div>

<div class="mb-4 position-relative" style="max-width: 400px;">
    <span class="position-absolute top-50 translate-middle-y start-0 ps-3 text-muted" style="z-index: 5;">
        <i class="bi bi-search text-secondary"></i>
    </span>
    <input 
        type="text" 
        id="searchDosenInput"
        placeholder="Cari nama dosen atau NIP..." 
        class="form-control"
        style="padding-left: 2.5rem; border-radius: 0.5rem; height: 42px;"
        autocomplete="off"
    />
</div>

<div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
    <div class="card-body p-4 bg-white" style="border-radius: 1rem;">
        <div class="row g-3 text-center">
            
            <div class="col-md-4">
                <a href="{{ route('admin.dosen.index', ['prodi' => 'Sistem Information']) }}" 
                   id="tab-SI" data-prodi-target="Sistem Informasi"
                   class="btn w-100 fs-6 fw-semibold d-flex align-items-center justify-content-center gap-2 btn-tab-custom tab-inactive">
                    <i class="bi bi-layout-text-sidebar-reverse"></i> <span>Sistem Informasi (SI)</span>
                </a>
            </div>
            
            <div class="col-md-4">
                <a href="{{ route('admin.dosen.index', ['prodi' => 'Teknologi Informasi']) }}" 
                   id="tab-TI" data-prodi-target="Teknologi Informasi"
                   class="btn w-100 fs-6 fw-semibold d-flex align-items-center justify-content-center gap-2 btn-tab-custom tab-inactive">
                    <i class="bi bi-cpu"></i> <span>Teknologi Informasi (TI)</span>
                </a>
            </div>
            
            <div class="col-md-4">
                <a href="{{ route('admin.dosen.index', ['prodi' => 'Informatika']) }}" 
                   id="tab-IF" data-prodi-target="Informatika"
                   class="btn w-100 fs-6 fw-semibold d-flex align-items-center justify-content-center gap-2 btn-tab-custom tab-inactive">
                    <i class="bi bi-code-slash"></i> <span>Informatika (IF)</span>
                </a>
            </div>

        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-table text-primary"></i> Daftar Dosen - Prodi 
            <span id="labelProdiAktif" class="badge bg-light text-primary border border-primary-subtle fs-6 ms-1">
                {{ $prodiSelected }}
            </span>
        </div>
        <span id="totalDosenBadge" class="badge bg-secondary rounded-pill px-3">0 Total Dosen</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small fw-bold">
                    <tr>
                        <th style="width: 60px;" class="ps-3">No</th>
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th class="pe-3">Jumlah Mahasiswa</th>
                    </tr>
                </thead>
                <tbody id="tbodyDosen">
                    @forelse($dosen as $index => $dsn)
                        <tr class="dosen-row" 
                            data-prodi="{{ $dsn->prodi_asal }}" 
                            data-nama="{{ strtolower($dsn->name) }}" 
                            data-nip="{{ $dsn->nim_nip }}">
                            <td class="ps-3 fw-medium text-secondary row-number">1</td>
                            <td><code class="text-dark fw-bold">{{ $dsn->nim_nip }}</code></td>
                            <td class="fw-semibold text-dark">{{ $dsn->name }}</td>
                            <td class="text-muted">{{ $dsn->email }}</td>
                            <td>{{ $dsn->phone }}</td>
                            <td class="pe-3">
                                @if($dsn->mahasiswa_bimbingan_count > 0)
                                    <span class="badge bg-info text-white rounded-pill px-3 py-1.5">
                                        <i class="bi bi-people mb-1"></i> {{ $dsn->mahasiswa_bimbingan_count }} bimbingan
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border rounded-pill px-3 py-1.5">
                                        <i class="bi bi-people mb-1"></i> 0 bimbingan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-folder-x fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada data dosen di sistem.
                            </td>
                        </tr>
                    @endforelse
                    
                    <tr id="notFoundRow" style="display: none;">
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-search fs-2 d-block mb-2 text-secondary"></i>
                            Nama dosen atau NIP tidak ditemukan di prodi manapun.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('searchDosenInput');
    const tableRows = document.querySelectorAll('.dosen-row');
    const notFoundRow = document.getElementById('notFoundRow');
    const labelProdiAktif = document.getElementById('labelProdiAktif');
    const totalDosenBadge = document.getElementById('totalDosenBadge');
    
    // Simpan inisialisasi awal prodi dari server
    let prodiAktifSekarang = "{{ $prodiSelected }}";

    const tabs = {
        'Sistem Informasi': document.getElementById('tab-SI'),
        'Teknologi Informasi': document.getElementById('tab-TI'),
        'Informatika': document.getElementById('tab-IF')
    };

    // Jalankan filter prodi bawaan saat halaman pertama kali dibuka
    filterBerdasarkanProdi(prodiAktifSekarang);

    // Mencegah link tab melakukan reload halaman, kita handle lewat JS agar fluid
    Object.keys(tabs).forEach(prodiKey => {
        if(tabs[prodiKey]) {
            tabs[prodiKey].addEventListener('click', function(e) {
                e.preventDefault();
                searchInput.value = ''; // Reset input pencarian
                prodiAktifSekarang = prodiKey;
                filterBerdasarkanProdi(prodiAktifSekarang);
            });
        }
    });

    // PENCARIAN REAL-TIME & AUTO TAB SLIDE CONTROL
    searchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();
        
        if (keyword === '') {
            filterBerdasarkanProdi(prodiAktifSekarang);
            return;
        }

        let cocokProdi = null;

        // Tahap 1: Cari tau dosen ini ada di prodi mana
        for (let row of tableRows) {
            const nama = row.getAttribute('data-nama');
            const nip = row.getAttribute('data-nip');
            if (nama.includes(keyword) || nip.includes(keyword)) {
                cocokProdi = row.getAttribute('data-prodi');
                break; // Hentikan loop jika sudah ketemu kluster prodinya
            }
        }

        // Tahap 2: Jika ketemu, paksa tab bergeser & tampilkan baris yang sesuai
        if (cocokProdi) {
            switchActiveTabUI(cocokProdi);
            labelProdiAktif.textContent = cocokProdi;

            let barisMuncul = 0;
            tableRows.forEach(row => {
                const nama = row.getAttribute('data-nama');
                const nip = row.getAttribute('data-nip');
                const prodi = row.getAttribute('data-prodi');

                if (prodi === cocokProdi && (nama.includes(keyword) || nip.includes(keyword))) {
                    row.style.display = '';
                    barisMuncul++;
                    row.querySelector('.row-number').textContent = barisMuncul;
                } else {
                    row.style.display = 'none';
                }
            });

            totalDosenBadge.textContent = barisMuncul + " Dosen Ditemukan";
            notFoundRow.style.display = 'none';
        } else {
            // Jika diketik asal dan tidak ada di prodi manapun
            tableRows.forEach(row => row.style.display = 'none');
            notFoundRow.style.display = '';
            totalDosenBadge.textContent = "0 Dosen";
        }
    });

    // Fungsi Pembantu: Render data murni berdasarkan Tab Prodi
    function filterBerdasarkanProdi(prodiTarget) {
        switchActiveTabUI(prodiTarget);
        labelProdiAktif.textContent = prodiTarget;
        
        let counter = 0;
        tableRows.forEach(row => {
            if (row.getAttribute('data-prodi') === prodiTarget) {
                row.style.display = '';
                counter++;
                row.querySelector('.row-number').textContent = counter;
            } else {
                row.style.display = 'none';
            }
        });
        
        totalDosenBadge.textContent = counter + " Total Dosen";
        notFoundRow.style.display = 'none';
    }

    // Fungsi Pembantu: Mengubah Class Style Active Gradient pada HTML Button
    function switchActiveTabUI(targetProdi) {
        Object.keys(tabs).forEach(key => {
            if(tabs[key]) {
                if (key === targetProdi) {
                    tabs[key].classList.remove('tab-inactive');
                    tabs[key].classList.add('tab-active');
                } else {
                    tabs[key].classList.remove('tab-active');
                    tabs[key].classList.add('tab-inactive');
                }
            }
        });
    }
});
</script>
@endsection