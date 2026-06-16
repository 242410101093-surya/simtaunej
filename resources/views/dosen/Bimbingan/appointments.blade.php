@extends('layouts.app')

@section('title', 'Jadwal Bimbingan')

@section('content')
<style>
    .ui-title { color: #0d1b2a !important; font-weight: 700 !important; letter-spacing: -0.025em; }
    .ui-icon-main { color: #0077b6 !important; }
    
    .tab-active { background: linear-gradient(to right, #03045e, #0077b6) !important; color: #ffffff !important; border: none !important; box-shadow: 0 4px 12px rgba(3, 4, 94, 0.15) !important; transition: all 0.2s; }
    .tab-inactive { background-color: rgba(248, 249, 250, 0.6) !important; border: 1px solid rgba(222, 226, 230, 0.8) !important; color: #4a5568 !important; transition: all 0.2s; }
    .tab-inactive:hover { background-color: #f1f3f5 !important; color: #1a202c !important; }
</style>

<div class="mb-4 d-flex align-items-center gap-3">
    <h2>
        <i class="bi bi-calendar-event ui-icon-main me-1"></i> 
        <span class="ui-title">MANAJEMEN JADWAL BIMBINGAN</span>
    </h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 0.75rem;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
    <div class="card-body p-4 bg-white" style="border-radius: 1rem;">
        <ul class="nav nav-pills nav-fill gap-3" id="jadwalTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100 fs-6 fw-semibold py-3 tab-active active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" style="border-radius: 0.75rem;">
                    <i class="bi bi-envelope-exclamation me-1"></i> Permintaan Jadwal
                    @if($pendingAppointments->count() > 0)
                        <span class="badge bg-danger ms-2 rounded-pill">{{ $pendingAppointments->count() }}</span>
                    @endif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100 fs-6 fw-semibold py-3 tab-inactive" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" style="border-radius: 0.75rem;">
                    <i class="bi bi-calendar-check me-1"></i> Jadwal Disetujui
                    @if($approvedAppointments->count() > 0)
                        <span class="badge bg-primary ms-2 rounded-pill">{{ $approvedAppointments->count() }}</span>
                    @endif
                </button>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="jadwalTabsContent">
    <!-- PENDING TAB -->
    <div class="tab-pane fade show active" id="pending" role="tabpanel">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="fw-semibold text-dark">
                    <i class="bi bi-hourglass-split text-warning me-1"></i> Permintaan Menunggu Persetujuan
                </div>
            </div>
            <div class="card-body p-0">
                @if($pendingAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small fw-bold">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">No</th>
                                    <th>Mahasiswa</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Catatan</th>
                                    <th>Dibuat</th>
                                    <th class="text-center pe-3" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingAppointments as $index => $appointment)
                                    <tr>
                                        <td class="ps-3 text-secondary">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $appointment->mahasiswa->name }}</div>
                                            <div class="small text-muted">{{ $appointment->mahasiswa->email }}</div>
                                        </td>
                                        <td><i class="bi bi-calendar2-day text-secondary me-1"></i> {{ $appointment->scheduled_date->format('d M Y') }}</td>
                                        <td><i class="bi bi-clock text-secondary me-1"></i> {{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }}</td>
                                        <td>
                                            @if($appointment->notes)
                                                <span class="text-secondary">{{ Str::limit($appointment->notes, 50) }}</span>
                                            @else
                                                <em class="text-muted">Tidak ada</em>
                                            @endif
                                        </td>
                                        <td class="text-muted small">{{ $appointment->created_at->diffForHumans() }}</td>
                                        <td class="text-center pe-3">
                                            <div class="btn-group shadow-sm" role="group">
                                                <form action="{{ route('dosen.appointments.approve', $appointment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-success btn-confirm"
                                                            data-message="Setujui jadwal ini?" data-title="Konfirmasi" data-confirm-text="Ya, Setujui" data-icon="question">
                                                        <i class="bi bi-check-lg"></i> Setujui
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $appointment->id }}">
                                                    <i class="bi bi-x-lg"></i> Tolak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-envelope-check text-muted" style="font-size: 3.5rem;"></i>
                        <h5 class="mt-3 text-muted fw-semibold">Tidak ada permintaan baru</h5>
                        <p class="text-muted">Semua permintaan jadwal bimbingan sudah Anda proses.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- APPROVED TAB -->
    <div class="tab-pane fade" id="approved" role="tabpanel">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="fw-semibold text-dark">
                    <i class="bi bi-calendar-check text-primary me-1"></i> Jadwal Bimbingan Disetujui
                </div>
            </div>
            <div class="card-body p-0">
                @if($approvedAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small fw-bold">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">No</th>
                                    <th>Mahasiswa</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Catatan</th>
                                    <th class="pe-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvedAppointments as $index => $appointment)
                                    <tr>
                                        <td class="ps-3 text-secondary">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $appointment->mahasiswa->name }}</div>
                                            <div class="small text-muted">{{ $appointment->mahasiswa->email }}</div>
                                        </td>
                                        <td><i class="bi bi-calendar2-day text-secondary me-1"></i> {{ $appointment->scheduled_date->format('d M Y') }}</td>
                                        <td><i class="bi bi-clock text-secondary me-1"></i> {{ \Carbon\Carbon::parse($appointment->scheduled_time)->format('H:i') }}</td>
                                        <td>
                                            @if($appointment->notes)
                                                <span class="text-secondary">{{ Str::limit($appointment->notes, 50) }}</span>
                                            @else
                                                <em class="text-muted">Tidak ada</em>
                                            @endif
                                        </td>
                                        <td class="pe-3">
                                            <span class="badge {{ $appointment->getStatusBadge() }} px-3 py-2 rounded-pill">
                                                {{ $appointment->getStatusText() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 3.5rem;"></i>
                        <h5 class="mt-3 text-muted fw-semibold">Belum ada jadwal</h5>
                        <p class="text-muted">Anda belum memiliki jadwal bimbingan yang disetujui.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modals for Rejection (Outside tabs to prevent layout shifts) -->
@foreach($pendingAppointments as $appointment)
    <div class="modal fade" id="rejectModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 1rem;">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #02023e 0%, #005f92 100%); border-radius: 1rem 1rem 0 0;">
                    <h5 class="modal-title fw-bold">Tolak Permintaan Jadwal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dosen.appointments.reject', $appointment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason" rows="3" required placeholder="Berikan alasan kenapa jadwal ditolak..." style="border-radius: 0.5rem;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3 border-top">
                        <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 0.5rem; font-weight: 500;">Batal</button>
                        <button type="submit" class="btn btn-danger px-4 py-2" style="border-radius: 0.5rem; font-weight: 500;">Tolak Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handling Tab Switch to update Active/Inactive styling
    const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            // Remove active style from all
            tabs.forEach(t => {
                t.classList.remove('tab-active');
                t.classList.add('tab-inactive');
            });
            // Add active style to current tab
            e.target.classList.remove('tab-inactive');
            e.target.classList.add('tab-active');
        });
    });
});
</script>
@endsection
