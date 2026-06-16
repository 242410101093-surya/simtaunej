@extends('layouts.app')

@section('title', 'Booking Jadwal Bimbingan')

@push('styles')
<style>
    .schedule-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }
    .schedule-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 24px;
    }
    .search-input-group {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.2s ease;
        background-color: #f8fafc;
    }
    .search-input-group:focus-within {
        border-color: #005f92;
        box-shadow: 0 0 0 4px rgba(0, 95, 146, 0.1);
        background-color: #ffffff;
    }
    .search-input-group input {
        border: none;
        box-shadow: none;
        background: transparent;
        padding: 10px 14px;
        font-size: 0.9rem;
    }
    .search-input-group input:focus {
        background: transparent;
        box-shadow: none;
        outline: none;
    }
    .search-icon-btn {
        background: transparent;
        border: none;
        color: #64748b;
        padding-left: 14px;
        display: flex;
        align-items: center;
    }
    
    /* Dosen Cards */
    .dosen-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.25s ease;
        overflow: hidden;
    }
    .dosen-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
        border-color: #cbd5e1;
    }
    .dosen-avatar {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: linear-gradient(135deg, #02023e 0%, #005f92 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: 0 4px 10px rgba(2, 2, 62, 0.15);
    }
    
    /* Modern Empty State */
    .empty-state-container {
        padding: 60px 20px;
        text-align: center;
    }
    .empty-state-icon-wrapper {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(2, 2, 62, 0.05) 0%, rgba(0, 95, 146, 0.05) 100%);
        border: 1px solid rgba(2, 2, 62, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px auto;
        color: #005f92;
        font-size: 2.5rem;
        position: relative;
        animation: floatPulse 3s infinite ease-in-out;
    }
    @keyframes floatPulse {
        0% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
        100% { transform: translateY(0); }
    }
    
    /* Buttons */
    .btn-book-now {
        background-color: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-book-now:hover {
        background-color: #005f92;
        color: white;
        border-color: #005f92;
        box-shadow: 0 4px 12px rgba(0, 95, 146, 0.2);
    }
    .btn-history {
        background-color: #ffffff;
        color: #005f92;
        border: 1.5px solid #005f92;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-history:hover {
        background-color: #005f92;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 95, 146, 0.1);
    }
    
    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }
    .modal-header {
        background: linear-gradient(135deg, #02023e 0%, #005f92 100%);
        color: white;
        padding: 20px 24px;
        border-bottom: none;
    }
    .modal-header .btn-close {
        filter: invert(1) grayscale(1) brightness(2);
    }
    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 20px 24px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card schedule-card">
                <div class="schedule-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #0f172a;">Pilih Jadwal Bimbingan</h4>
                        <p class="text-muted small mb-0">Cari dosen pembimbing Anda dan ajukan jadwal bimbingan tatap muka atau daring.</p>
                    </div>
                    <div class="d-flex gap-2 align-items-center w-100 w-md-auto">
                        <div class="search-input-group d-flex align-items-center flex-grow-1 w-100 w-md-auto" style="max-width: 300px;">
                            <span class="search-icon-btn"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchDosen" class="form-control" placeholder="Cari nama dosen...">
                        </div>
                        <a href="{{ route('mahasiswa.appointments.my') }}" class="btn btn-history text-nowrap d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-event"></i> Riwayat Booking
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row" id="dosenContainer">
                        @foreach($dosens as $dosen)
                            @php
                                // Ambil inisial nama
                                $words = explode(' ', $dosen->name);
                                $initials = '';
                                foreach ($words as $word) {
                                    $initials .= strtoupper(substr($word, 0, 1));
                                    if(strlen($initials) >= 2) break;
                                }
                            @endphp
                            <div class="col-md-6 col-lg-4 mb-4 dosen-item" data-name="{{ strtolower($dosen->name) }}">
                                <div class="card dosen-card h-100 p-3">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="dosen-avatar">
                                            {{ $initials ?: 'DS' }}
                                        </div>
                                        <div class="overflow-hidden">
                                            <h5 class="fw-bold mb-0 text-truncate text-slate-800" title="{{ $dosen->name }}">{{ $dosen->name }}</h5>
                                            <small class="text-muted text-truncate d-block"><i class="bi bi-envelope me-1"></i>{{ $dosen->email }}</small>
                                        </div>
                                    </div>
                                    <div class="mt-auto border-top pt-3">
                                        <button
                                            type="button"
                                            class="btn btn-book-now w-100 d-flex align-items-center justify-content-center gap-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#bookingModal{{ $dosen->id }}">
                                            <i class="bi bi-calendar-plus-fill"></i> Pilih Jadwal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Search No Match State -->
                    <div id="noMatchMessage" class="empty-state-container d-none">
                        <div class="empty-state-icon-wrapper">
                            <i class="bi bi-person-exclamation"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-3">Dosen Tidak Ditemukan</h5>
                        <p class="text-muted" style="max-width: 400px; margin: 0 auto;">Kata kunci pencarian Anda tidak cocok dengan nama dosen manapun di sistem.</p>
                    </div>

                    <!-- Database Empty State -->
                    @if($dosens->isEmpty())
                        <div class="empty-state-container">
                            <div class="empty-state-icon-wrapper">
                                <i class="bi bi-person-x"></i>
                            </div>
                            <h5 class="fw-bold text-dark mt-3">Tidak Ada Dosen Tersedia</h5>
                            <p class="text-muted" style="max-width: 400px; margin: 0 auto;">Saat ini belum ada data dosen pembimbing yang terdaftar di dalam sistem.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Render Modals Outside Container at Root Level to avoid parent CSS transforms, transitions, and relative scopes -->
@foreach($dosens as $dosen)
    @php
        // Ambil inisial nama
        $words = explode(' ', $dosen->name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            if(strlen($initials) >= 2) break;
        }
    @endphp
    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal{{ $dosen->id }}" tabindex="-1" aria-labelledby="bookingModalLabel{{ $dosen->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content shadow-lg">
                <div class="modal-header d-flex align-items-center">
                    <i class="bi bi-calendar-check-fill fs-5 me-2"></i>
                    <h5 class="modal-title fw-bold" id="bookingModalLabel{{ $dosen->id }}">Booking Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('mahasiswa.appointments.book') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">

                        <div class="p-3 bg-light rounded-3 mb-4 border d-flex align-items-center gap-3">
                            <div class="dosen-avatar" style="width: 44px; height: 44px; font-size: 1rem;">
                                {{ $initials ?: 'DS' }}
                            </div>
                            <div>
                                <span class="text-muted small d-block">Dosen Pembimbing</span>
                                <span class="fw-bold text-dark">{{ $dosen->name }}</span>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Tanggal Bimbingan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="scheduled_date" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Waktu Bimbingan <span class="text-danger">*</span></label>
                                <select class="form-select" name="scheduled_time" required>
                                    <option value="" disabled selected>Pilih jam...</option>
                                    <option value="09:00">09:00 WIB</option>
                                    <option value="09:30">09:30 WIB</option>
                                    <option value="10:00">10:00 WIB</option>
                                    <option value="10:30">10:30 WIB</option>
                                    <option value="11:00">11:00 WIB</option>
                                    <option value="11:30">11:30 WIB</option>
                                    <option value="13:00">13:00 WIB</option>
                                    <option value="13:30">13:30 WIB</option>
                                    <option value="14:00">14:00 WIB</option>
                                    <option value="14:30">14:30 WIB</option>
                                    <option value="15:00">15:00 WIB</option>
                                    <option value="15:30">15:30 WIB</option>
                                    <option value="16:00">16:00 WIB</option>
                                    <option value="16:30">16:30 WIB</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Catatan Tambahan (Opsional)</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Tulis progres bab skripsi atau kendala yang ingin dibahas..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between p-4 bg-light border-top" style="border-radius: 0 0 16px 16px;">
                        <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 10px; font-weight: 600;">
                            <i class="bi bi-check2-circle me-1"></i> Ajukan Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchDosen');
        const dosenItems = document.querySelectorAll('.dosen-item');
        const noMatchMessage = document.getElementById('noMatchMessage');

        if(searchInput) {
            searchInput.addEventListener('input', function () {
                const filter = this.value.toLowerCase().trim();
                let hasVisibleItems = false;

                dosenItems.forEach(function (item) {
                    const name = item.getAttribute('data-name');
                    if (name.includes(filter)) {
                        item.classList.remove('d-none');
                        hasVisibleItems = true;
                    } else {
                        item.classList.add('d-none');
                    }
                });

                if (!hasVisibleItems && filter !== '') {
                    noMatchMessage.classList.remove('d-none');
                } else {
                    noMatchMessage.classList.add('d-none');
                }
            });
        }
    });
</script>
@endsection