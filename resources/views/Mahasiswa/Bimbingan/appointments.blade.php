@extends('layouts.app')

@section('title', 'Booking Jadwal Bimbingan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <h4 class="card-title mb-0">Pilih Jadwal Bimbingan</h4>
                    <div class="d-flex gap-2 w-100 w-sm-auto justify-content-end">
                        <div class="input-group input-group-sm" style="max-width: 250px;">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="searchDosen" class="form-control" placeholder="Cari nama dosen...">
                        </div>
                        <a href="{{ route('mahasiswa.appointments.my') }}" class="btn btn-outline-primary btn-sm shrink-0">
                            <i class="bi bi-list"></i> Riwayat Booking
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row" id="dosenContainer">
                        @foreach($dosens as $dosen)
                            <div class="col-md-6 col-lg-4 mb-4 dosen-item" data-name="{{ strtolower($dosen->name) }}">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="mb-0 dosen-name">{{ $dosen->name }}</h5>
                                        <small class="text-muted">{{ $dosen->email }}</small>
                                    </div>
                                    <div class="card-body d-flex align-items-end">
                                        <button
                                            type="button"
                                            class="btn btn-primary w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#bookingModal{{ $dosen->id }}">
                                            <i class="bi bi-calendar-plus"></i> Pilih Jadwal
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="bookingModal{{ $dosen->id }}" tabindex="-1" aria-labelledby="bookingModalLabel{{ $dosen->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bookingModalLabel{{ $dosen->id }}">Booking dengan {{ $dosen->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form action="{{ route('mahasiswa.appointments.book') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" name="scheduled_date" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Waktu</label>
                                                        <select class="form-control" name="scheduled_time" required>
                                                            <option value="">Pilih waktu</option>
                                                            <option value="09:00">09:00</option>
                                                            <option value="09:30">09:30</option>
                                                            <option value="10:00">10:00</option>
                                                            <option value="10:30">10:30</option>
                                                            <option value="11:00">11:00</option>
                                                            <option value="11:30">11:30</option>
                                                            <option value="13:00">13:00</option>
                                                            <option value="13:30">13:30</option>
                                                            <option value="14:00">14:00</option>
                                                            <option value="14:30">14:30</option>
                                                            <option value="15:00">15:00</option>
                                                            <option value="15:30">15:30</option>
                                                            <option value="16:00">16:00</option>
                                                            <option value="16:30">16:30</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label class="form-label mt-3">Catatan (Opsional)</label>
                                                <textarea class="form-control" name="notes" rows="3" placeholder="Tulis progres atau kendala..."></textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Booking Jadwal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="noMatchMessage" class="text-center py-5 d-none">
                        <i class="bi bi-person-exclamation text-muted" style="font-size:3rem"></i>
                        <h5 class="mt-3 text-muted">Dosen tidak ditemukan</h5>
                        <p class="text-muted">Kata kunci tidak cocok dengan nama dosen manapun.</p>
                    </div>

                    @if($dosens->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-person-x text-muted" style="font-size:3rem"></i>
                            <h5 class="mt-3 text-muted">Tidak ada dosen tersedia</h5>
                            <p class="text-muted">Belum ada dosen yang terdaftar di sistem.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

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