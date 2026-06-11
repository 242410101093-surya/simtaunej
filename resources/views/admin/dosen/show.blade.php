@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-workspace me-2"></i>Detail Dosen</h2>
        <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th width="200">Nama</th><td>{{ $dosen->name }}</td></tr>
                <tr><th>Email</th><td>{{ $dosen->email }}</td></tr>
                <tr><th>NIP</th><td>{{ $dosen->nim_nip ?? '-' }}</td></tr>
                <tr><th>Telepon</th><td>{{ $dosen->phone ?? '-' }}</td></tr>
                <tr><th>Role</th><td><span class="badge bg-primary text-capitalize">{{ $dosen->role }}</span></td></tr>
                <tr><th>Terdaftar</th><td>{{ $dosen->created_at->format('d M Y') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
