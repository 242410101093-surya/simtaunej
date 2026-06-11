@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-fill me-2"></i>Detail Mahasiswa</h2>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th width="200">Nama</th><td>{{ $mahasiswa->name }}</td></tr>
                <tr><th>Email</th><td>{{ $mahasiswa->email }}</td></tr>
                <tr><th>NIM</th><td>{{ $mahasiswa->nim_nip ?? '-' }}</td></tr>
                <tr><th>Telepon</th><td>{{ $mahasiswa->phone ?? '-' }}</td></tr>
                <tr><th>Role</th><td><span class="badge bg-success text-capitalize">{{ $mahasiswa->role }}</span></td></tr>
                <tr><th>Terdaftar</th><td>{{ $mahasiswa->created_at->format('d M Y') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
