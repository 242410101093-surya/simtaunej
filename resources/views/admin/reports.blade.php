@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4"><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan & Statistik</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-people-fill fs-1"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ \App\Models\User::where('role','mahasiswa')->count() }}</div>
                        <div>Total Mahasiswa</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-person-workspace fs-1"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ \App\Models\User::where('role','dosen')->count() }}</div>
                        <div>Total Dosen</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-journal-text fs-1"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ \App\Models\Bimbingan::count() }}</div>
                        <div>Total Bimbingan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header fw-bold">Rekap Bimbingan per Status</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr><th>Status</th><th>Jumlah</th></tr>
                </thead>
                <tbody>
                    @foreach(['pending' => 'Menunggu Review', 'revisi' => 'Perlu Revisi', 'approved' => 'Disetujui'] as $key => $label)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ \App\Models\Bimbingan::where('status', $key)->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
