@extends('layouts.app')

@section('title', 'Data Dosen - SIM-TA UNEJ')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">
        <i class="bi bi-person-lines-fill text-primary me-2"></i> DAFTAR DATA DOSEN FASILKOM
    </h2>
    <div class="row my-4">
    <div class="col-md-6 col-lg-4">
        <div class="input-group shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <span class="input-group-text bg-white border-end-0 text-secondary ps-3">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="searchDosen" class="form-control border-start-0 ps-1 py-2.5" placeholder="Cari nama dosen atau bidang minat..." style="font-size: 0.95rem; font-weight: 500;">
        </div>
    </div>
</div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
    <div class="card-body p-3">
        <ul class="nav nav-pills nav-fill gap-2" id="prodiTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold py-2.5" id="si-tab" data-bs-toggle="tab" data-bs-target="#si-content" type="button" role="tab" style="border-radius: 12px;">
                    <i class="bi bi-window-sidebar me-2"></i>Sistem Informasi (SI)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold py-2.5" id="ti-tab" data-bs-toggle="tab" data-bs-target="#ti-content" type="button" role="tab" style="border-radius: 12px;">
                    <i class="bi bi-cpu me-2"></i>Teknologi Informasi (TI)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold py-2.5" id="if-tab" data-bs-toggle="tab" data-bs-target="#if-content" type="button" role="tab" style="border-radius: 12px;">
                    <i class="bi bi-code-slash me-2"></i>Informatika (IF)
                </button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="prodiTabsContent">
    
    <div class="tab-pane fade show active" id="si-content" role="tabpanel" aria-labelledby="si-tab">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Dosen</th>
                            <th>NIP / NRP</th>
                            <th>Jab. Fungsional</th>
                            <th>Bidang Minat</th>
                            <th class="pe-4">ID SINTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="ps-4">1</td><td class="fw-bold">Fahrobby Adnan, S.Kom., M.MSI.</td><td>198706192014041001</td><td>Lektor</td><td>User Interface/User Experience</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5997801</span></td></tr>
                        <tr><td class="ps-4">2</td><td class="fw-bold">Katarina Leba, S.Ag., M.Th.</td><td>197904292008122002</td><td>Lektor</td><td>Pastoral Catechesis</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6650362</span></td></tr>
                        <tr><td class="ps-4">3</td><td class="fw-bold">Oktalia Juwita, S.Kom., M.MT.</td><td>198110202014042001</td><td>Lektor</td><td>Information System Management & Strategy</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5997836</span></td></tr>
                        <tr><td class="ps-4">4</td><td class="fw-bold">Fajrin Nurman Arifin, ST., M.Eng.</td><td>198511282015041002</td><td>Lektor</td><td>Data & Information Management</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5991167</span></td></tr>
                        <tr><td class="ps-4">5</td><td class="fw-bold">Beny Prasetyo, S.Kom., M.Kom.</td><td>199110172020121002</td><td>Lektor</td><td>E-government</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6020905</span></td></tr>
                        <tr><td class="ps-4">6</td><td class="fw-bold">Karina Nine Amalia, S.Kom., M.Kom.</td><td>199512092022032023</td><td>Asisten Ahli</td><td>BUSINESS PROCESS MANAGEMENT (BPM)</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6786980</span></td></tr>
                        <tr><td class="ps-4">7</td><td class="fw-bold">Tri Agustina Nugrahani, S.Kom., M.Kom.</td><td>199208222022032014</td><td>Asisten Ahli</td><td>SOFTWARE DESIGN</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6786979</span></td></tr>
                        <tr><td class="ps-4">8</td><td class="fw-bold">Maliatul Fitriyasari, M.Sc.</td><td>199503152023212038</td><td>Asisten Ahli</td><td>Computer Vision</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6873959</span></td></tr>
                        <tr><td class="ps-4">9</td><td class="fw-bold">Harry Soepandi, S.Kom., M.Kom.</td><td>197604252023211002</td><td>Asisten Ahli</td><td>SOFTWARE REQUIREMENT</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6782342</span></td></tr>
                        <tr><td class="ps-4">10</td><td class="fw-bold">Khoirunnisa' Afandi, M.Kom.</td><td>199412282024062001</td><td>Asisten Ahli</td><td>Data & Information Management</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6827664</span></td></tr>
                        <tr><td class="ps-4">11</td><td class="fw-bold">Martiana Kholila Fadhil, M.Kom.</td><td>199907192024062001</td><td>Asisten Ahli</td><td>Information Technology Adoption</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6913114</span></td></tr>
                        <tr><td class="ps-4">12</td><td class="fw-bold">M. Habibullah Arief, M.Kom.</td><td>199202112024061001</td><td>Asisten Ahli</td><td>Geographic Information System</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6803809</span></td></tr>
                        <tr><td class="ps-4">13</td><td class="fw-bold">Ifrina Nuritha, S.Kom., M.Kom.</td><td>199008292025062003</td><td>Tenaga Pengajar</td><td>Proses Mining</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6036564</span></td></tr>
                        <tr><td class="ps-4">14</td><td class="fw-bold">Vina Dewi Ramadhanty, S.Kom, M.Kom.</td><td>200001162025062013</td><td>Tenaga Pengajar</td><td>IT risk management</td><td class="pe-4"><span class="text-muted">-</span></td></tr>
                        <tr><td class="ps-4">15</td><td class="fw-bold">Shynta Ayu Dwi Darmawan, S.Kom, MMSI.</td><td>199809192025062010</td><td>Tenaga Pengajar</td><td>Web Mining</td><td class="pe-4"><span class="text-muted">-</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="ti-content" role="tabpanel" aria-labelledby="ti-tab">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Dosen</th>
                            <th>NIP / NRP</th>
                            <th>Jab. Fungsional</th>
                            <th>Bidang Minat</th>
                            <th class="pe-4">ID SINTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="ps-4">1</td><td class="fw-bold">Achmad Maududie, ST., M.Sc.</td><td>197004221995121001</td><td>Lektor</td><td>Teks Mining</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5988580</span></td></tr>
                        <tr><td class="ps-4">2</td><td class="fw-bold">Diah Ayu Retnani Wulandari, ST., M.Eng.</td><td>198603052014042001</td><td>Lektor</td><td>Network Engineer</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6644873</span></td></tr>
                        <tr><td class="ps-4">3</td><td class="fw-bold">Prof. Dr. Saiful Bukhori, ST., M.Kom.</td><td>196811131994121001</td><td>Guru Besar</td><td>GAME INTELLEGENCE</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5975640</span></td></tr>
                        <tr><td class="ps-4">4</td><td class="fw-bold">Anang Andrianto, S.T., M.T.</td><td>196906151997021002</td><td>Lektor</td><td>Embedded System</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6018490</span></td></tr>
                        <tr><td class="ps-4">5</td><td class="fw-bold">Yanuar Nurdiansyah, ST., M.Cs.</td><td>198201012010121004</td><td>Lektor</td><td>decision making</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6091295</span></td></tr>
                        <tr><td class="ps-4">6</td><td class="fw-bold">Dr. Dwiretno Istiyadi S, ST., M.Kom.</td><td>197803302003121003</td><td>Lektor</td><td>Computer Vision</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6060241</span></td></tr>
                        <tr><td class="ps-4">7</td><td class="fw-bold">Windi Eka Yulia Retnani, S.Kom., MT.</td><td>198403052010122002</td><td>Lektor Kepala</td><td>Software Quality</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6009785</span></td></tr>
                        <tr><td class="ps-4">8</td><td class="fw-bold">Priza Pandunata, S.Kom., M.Sc.</td><td>198301312015041001</td><td>Lektor</td><td>Data Mining</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6007478</span></td></tr>
                        <tr><td class="ps-4">9</td><td class="fw-bold">Nova El Maidah, S.Si., M.Cs.</td><td>198411012015042001</td><td>Asisten Ahli</td><td>Expert System</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5997261</span></td></tr>
                        <tr><td class="ps-4">10</td><td class="fw-bold">Mohammad Zarkasi, S.Kom., M.Kom.</td><td>199011112019031018</td><td>Asisten Ahli</td><td>Distributed System</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6787927</span></td></tr>
                        <tr><td class="ps-4">11</td><td class="fw-bold">Yudha Alif Auliya, S.Kom., M.Kom.</td><td>199206302022031009</td><td>Asisten Ahli</td><td>Machine Learning</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6649047</span></td></tr>
                        <tr><td class="ps-4">12</td><td class="fw-bold">Diksy Media Firmansyah, S.Kom., M.Kom.</td><td>199112132023211015</td><td>Asisten Ahli</td><td>System Security</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6015588</span></td></tr>
                        <tr><td class="ps-4">13</td><td class="fw-bold">Dwi Wijonarko, M.Kom.</td><td>198511272023211013</td><td>Asisten Ahli</td><td>Multiplatform mobile application development</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6669073</span></td></tr>
                        <tr><td class="ps-4">14</td><td class="fw-bold">Akbar Pandu Segara, M.Kom.</td><td>199508242024061001</td><td>Asisten Ahli</td><td>Intelligent Computer Network</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6915551</span></td></tr>
                        <tr><td class="ps-4">15</td><td class="fw-bold">Narandha Arya Ranggianto, S.Kom., M.Kom.</td><td>199803082024061001</td><td>Asisten Ahli</td><td>Game Development</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6910468</span></td></tr>
                        <tr><td class="ps-4">16</td><td class="fw-bold">Abbi Nizar Muhammad, S.Kom., M.T.I.</td><td>199609092025061007</td><td>Tenaga Pengajar</td><td>HCI</td><td class="pe-4"><span class="text-muted">-</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="if-content" role="tabpanel" aria-labelledby="if-tab">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Dosen</th>
                            <th>NIP / NRP</th>
                            <th>Jab. Fungsional</th>
                            <th>Bidang Minat</th>
                            <th class="pe-4">ID SINTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="ps-4">1</td><td class="fw-bold">Prof. Drs. Antonius Cahya Prihandoko, M.App.Sc., Ph.D.</td><td>196909281993021001</td><td>Guru Besar</td><td>CRYPTOGRAPHY</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5984024</span></td></tr>
                        <tr><td class="ps-4">2</td><td class="fw-bold">Prof. Drs. Slamin, M.Comp.Sc., Ph.D.</td><td>196704201992011001</td><td>Guru Besar</td><td>Graph</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">55671</span></td></tr>
                        <tr><td class="ps-4">3</td><td class="fw-bold">Nelly Oktavia Adiwijaya, S.Si., MT.</td><td>198410242009122008</td><td>Lektor</td><td>DATA SCIENCE</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6042438</span></td></tr>
                        <tr><td class="ps-4">4</td><td class="fw-bold">M. Arief Hidayat, S.Kom., M. Kom.</td><td>198101232010121003</td><td>Lektor</td><td>Intelligent Multimedia System</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">5997504</span></td></tr>
                        <tr><td class="ps-4">5</td><td class="fw-bold">Muhammad ‘Ariful Furqon, S.Pd., M.Kom.</td><td>199407262020121005</td><td>Asisten Ahli</td><td>KNOWLEDGE GRAPH</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6757022</span></td></tr>
                        <tr><td class="ps-4">6</td><td class="fw-bold">Tio Dharmawan, S.Kom., M.Kom.</td><td>199111122022031011</td><td>Asisten Ahli</td><td>Computer Vision</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6020903</span></td></tr>
                        <tr><td class="ps-4">7</td><td class="fw-bold">Januar Adi Putra, S.Kom., M.Kom.</td><td>199301312022031005</td><td>Asisten Ahli</td><td>DIGITAL IMAGE PROCESSING</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6649387</span></td></tr>
                        <tr><td class="ps-4">8</td><td class="fw-bold">Gama Wisnu Fajarianto, S.Kom., M.Kom.</td><td>198811132024061001</td><td>Asisten Ahli</td><td>INTELLIGENT SYSTEM</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6653927</span></td></tr>
                        <tr><td class="ps-4">9</td><td class="fw-bold">Gayatri Dwi Santika, S.SI., M.Kom.</td><td>199201162023212044</td><td>Asisten Ahli</td><td>DATA INTELLIGENCE</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6650859</span></td></tr>
                        <tr><td class="ps-4">10</td><td class="fw-bold">Qurrota A’yuni Ar Ruhimat, S.Pd., M.Sc.</td><td>760018029</td><td>Tenaga Pengajar</td><td>Data Visualisasi</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6652827</span></td></tr>
                        <tr><td class="ps-4">11</td><td class="fw-bold">Brian Rizqi Paradisiaca Darnoto, S.Kom., M.Kom.</td><td>199804272024061001</td><td>Asisten Ahli</td><td>Information Retrieval</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6902866</span></td></tr>
                        <tr><td class="ps-4">12</td><td class="fw-bold">Damar Novtahaning, M.Sc.</td><td>199711132024062005</td><td>Asisten Ahli</td><td>Machine Learning</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6913104</span></td></tr>
                        <tr><td class="ps-4">13</td><td class="fw-bold">Dony Bahtera Firmawan, S.Kom., M.Kom.</td><td>199711202024061001</td><td>Asisten Ahli</td><td>Natural Language Processing</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6913143</span></td></tr>
                        <tr><td class="ps-4">14</td><td class="fw-bold">Erik Yohan Kartiko, S.Pd., M.Kom.</td><td>199512292024061001</td><td>Asisten Ahli</td><td>Immersive Geoinformatics</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6920886</span></td></tr>
                        <tr><td class="ps-4">15</td><td class="fw-bold">Muhammad Andryan Wahyu Saputra, M.Kom.</td><td>200109062024061001</td><td>Asisten Ahli</td><td>Intelligent Software</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6913117</span></td></tr>
                        <tr><td class="ps-4">16</td><td class="fw-bold">Rizky Alfanio Atmoko, S.Si., M.Sc.</td><td>199205112024061001</td><td>Asisten Ahli</td><td>Quantum Computing</td><td class="pe-4"><span class="badge bg-info-subtle text-info fw-semibold">6915554</span></td></tr>
                        <tr><td class="ps-4">17</td><td class="fw-bold">Stanislaus Jiwandana Pinasthika, S.Kom., M.Cs.</td><td>199705232025061006</td><td>Tenaga Pengajar</td><td>BIOINFORMATICS</td><td class="pe-4"><span class="text-muted">-</span></td></tr>
                        <tr><td class="ps-4">18</td><td class="fw-bold">Fadhel Akhmad Hizham, S.Kom., M.Kom.</td><td>199705212025061007</td><td>Tenaga Pengajar</td><td>Teks Mining</td><td class="pe-4"><span class="text-muted">-</span></td></tr>
                        <tr><td class="ps-4">19</td><td class="fw-bold">Annisa Fitri Maghfiroh Harvyant, S.Si., M.Si.</td><td>199801292025062009</td><td>Tenaga Pengajar</td><td>precision agriculture</td><td class="pe-4"><span class="text-muted">-</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    #prodiTabs .nav-link {
        color: #475569;
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
        transition: all 0.3s ease;
    }
    #prodiTabs .nav-link:hover {
        color: #0077B6;
        background-color: #F1F5F9;
    }
    #prodiTabs .nav-link.active {
        background: linear-gradient(135deg, #03045E 0%, #0077B6 100%) !important;
        color: white !important;
        border: none;
        box-shadow: 0 4px 12px rgba(3, 4, 94, 0.2);
    }
    .table th {
        background-color: #F8FAFC !important;
        color: #1E293B;
        font-weight: 700;
        padding: 14px 8px !important;
    }
    .table td {
        padding: 14px 8px !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('searchDosen').addEventListener('input', function() {
        let keyword = this.value.toLowerCase().trim();
        let tableRows = document.querySelectorAll('.tab-content table tbody tr');
        let tabs = document.querySelectorAll('.tab-content .tab-pane');
        
        // 1. JIKA KOLOM PENCARIAN KOSONG: Tampilkan semua data kembali
        if (keyword === '') {
            tableRows.forEach(row => row.style.display = '');
            return;
        }

        let targetTabId = null;

        // 2. TAHAP PENCARIAN: Cek kecocokan di setiap baris dosen
        tableRows.forEach(function(row) {
            let namaDosen = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
            let bidangMinat = row.cells[4] ? row.cells[4].textContent.toLowerCase() : '';

            if (namaDosen.includes(keyword) || bidangMinat.includes(keyword)) {
                row.style.display = ''; // Tampilkan jika cocok
                
                // Cari tahu baris ini berada di tab prodi mana, lalu simpan ID-nya
                if (!targetTabId) {
                    let parentTabPane = row.closest('.tab-pane');
                    if (parentTabPane) {
                        targetTabId = parentTabPane.getAttribute('id');
                    }
                }
            } else {
                row.style.display = 'none'; // Sembunyikan jika tidak cocok
            }
        });

        // 3. TAHAP PERPINDAHAN TAB: Pindahkan tab aktif secara otomatis ke prodi dosen tersebut
        if (targetTabId) {
            let targetTabButtonId = targetTabId.replace('-content', '-tab');
            let tabButton = document.getElementById(targetTabButtonId);
            
            if (tabButton && !tabButton.classList.contains('active')) {
                // Menggunakan selector bawaan Bootstrap yang jauh lebih aman dan stabil
                let triggerEl = document.querySelector(`#prodiTabs button[id="${targetTabButtonId}"]`);
                if (triggerEl) {
                    let tabInstance = bootstrap.Tab.getOrCreateInstance(triggerEl);
                    tabInstance.show();
                }
            }
        }
    });
</script>
@endpush