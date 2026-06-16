<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta class="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Bimbingan TA - UNEJ')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ url('/logo-unej.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --theme-bg: #F8FAFC;
            --theme-navy-grad: linear-gradient(135deg, #02023e 0%, #005f92 100%);
            --theme-blue-grad: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            --theme-card: #ffffff;
            --theme-text: #0f172a;
            --theme-muted: #64748b;
            --card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 4px 12px -2px rgba(0, 0, 0, 0.02);
            --sidebar-width: 280px;
            --unej-red: #ef4444;
            --unej-green: #10b981;
            --unej-yellow: #f59e0b;
            --unej-navy: #02023e;
            --unej-blue: #3b82f6;
            --unej-cyan: #06b6d4;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--theme-bg);
            color: var(--theme-text);
            overflow: hidden;
            letter-spacing: -0.01em;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .navbar-unej {
            background: var(--theme-navy-grad) !important;
            height: 72px;
            padding: 0 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: white !important;
            font-size: 2rem;
            font-weight: 700;
        }

        .app-container {
            display: flex;
            height: calc(100vh - 72px);
        }

        .sidebar-modern {
            width: var(--sidebar-width);
            background: #02023e;
            padding: 24px 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-modern .nav-link {
            color: #94a3b8 !important;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .sidebar-modern .nav-link i {
            font-size: 1.15rem;
            transition: all 0.2s ease;
        }

        .sidebar-modern .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white !important;
            transform: translateX(2px);
        }

        .sidebar-modern .nav-link.active {
            background: var(--theme-blue-grad);
            color: white !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .sidebar-modern .nav-link.active i {
            color: white !important;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 40px;
            background: #f8fafc;
            scrollbar-gutter: stable;
        }

        /* Modernize Card */
        .card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            border-radius: 16px !important;
            box-shadow: var(--card-shadow) !important;
            padding: 24px !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01) !important;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
            padding: 0 0 16px 0 !important;
        }

        /* Modernize Buttons */
        .btn-unej-primary, .btn-primary {
            background: var(--theme-blue-grad) !important;
            color: white !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15) !important;
            transition: all 0.2s ease !important;
        }

        .btn-unej-primary:hover, .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.25) !important;
            opacity: 0.95;
            color: white !important;
        }

        /* Modernize Form Inputs */
        .form-control, .form-select {
            border-radius: 10px !important;
            border: 1.5px solid #e2e8f0 !important;
            padding: 10px 16px !important;
            font-size: 0.925rem !important;
            transition: all 0.2s ease !important;
            color: #0f172a !important;
            background-color: #ffffff !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
            outline: none !important;
        }

        /* Modernize Tables */
        .table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        .table th {
            font-weight: 700 !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.05em !important;
            color: var(--theme-muted) !important;
            background-color: #f8fafc !important;
            padding: 14px 16px !important;
            border-bottom: 2px solid #e2e8f0 !important;
        }

        .table td {
            padding: 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155 !important;
            font-size: 0.9rem !important;
        }

        .table tr:last-child td {
            border-bottom: none !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* Modern Badges */
        .badge {
            padding: 6px 12px !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            border-radius: 8px !important;
            letter-spacing: 0.02em !important;
        }

        .bg-primary-subtle {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
            border: 1px solid #dbeafe !important;
        }

        .bg-success-subtle {
            background-color: #ecfdf5 !important;
            color: #047857 !important;
            border: 1px solid #d1fae5 !important;
        }

        .bg-warning-subtle {
            background-color: #fffbef !important;
            color: #b45309 !important;
            border: 1px solid #fef3c7 !important;
        }

        .bg-danger-subtle {
            background-color: #fdf2f2 !important;
            color: #b91c1c !important;
            border: 1px solid #fde8e8 !important;
        }

        .footer {
            margin-top: 40px !important;
            padding: 24px 0 !important;
            border-top: 1px solid #e2e8f0 !important;
            color: var(--theme-muted) !important;
            font-size: 0.85rem !important;
        }

        /* Prevent modal layout shift / shaking */
        body.modal-open,
        body.modal-open .navbar-unej,
        body.modal-open .app-container,
        .modal,
        .modal-backdrop {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        /* Global Loading Overlay */
        .global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(2, 2, 62, 0.85); /* Semi-transparent dark navy base */
            backdrop-filter: blur(8px);
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .global-loader.d-none {
            display: none !important;
        }

        .loader-content {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
        }

        /* Spinner design: fading gradient rotating ring styled in blue */
        .loader-spinner {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, rgba(37, 99, 235, 0.05) 10%, #2563eb 50%, #3b82f6 100%);
            -webkit-mask: radial-gradient(farthest-side, transparent 75%, #000 76%);
            mask: radial-gradient(farthest-side, transparent 75%, #000 76%);
            animation: spin-clockwise 1s linear infinite;
        }

        .loader-text {
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            animation: text-pulse 1.5s ease-in-out infinite;
            text-transform: uppercase;
        }

        @keyframes spin-clockwise {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes text-pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Global Loader Overlay -->
    <div id="global-loader" class="global-loader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <div class="loader-text">LOADING...</div>
        </div>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-unej">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <img src="{{ url('/logo-unej.png') }}" alt="Logo UNEJ" style="height: 40px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                <span class="fw-bold fs-4 text-white">SIM-TA UNEJ</span>
            </a>

            <div class="ms-auto">
                @auth
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Avatar" class="rounded-circle shadow-sm border border-2 border-white" style="width: 30px; height: 30px; object-fit: cover;">
                            @else
                                <i class="bi bi-person-circle fs-5 text-light"></i>
                            @endif
                            <span class="text-white fw-medium">{{ auth()->user()->name }}</span>
                            <span class="badge bg-light text-dark text-uppercase fs-7 ms-1" style="padding: 3px 8px; border-radius: 6px;">{{ auth()->user()->role === 'admin' ? 'Kepala Prodi' : auth()->user()->role }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li>
                                <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="bi bi-person-gear me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="app-container">
        
        @auth
            <aside class="sidebar-modern">
                <ul class="nav flex-column gap-1">
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('dosen.dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-3 fs-5"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    @if(auth()->user()->role === 'dosen')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dosen.mahasiswa.*') ? 'active' : '' }}" href="{{ route('dosen.mahasiswa.index') }}">
                                <i class="bi bi-people me-3 fs-5"></i>
                                <span>Data Mahasiswa</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dosen.appointments.*') || request()->routeIs('dosen.schedule.*') ? 'active' : '' }}" href="{{ route('dosen.appointments.index') }}">
                                <i class="bi bi-calendar3 me-3 fs-5"></i>
                                <span>Jadwal Bimbingan</span>
                            </a>
                        </li>
                    @endif
                    
                    @if(auth()->user()->role === 'mahasiswa')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.bimbingan.*') ? 'active' : '' }}" href="{{ route('mahasiswa.bimbingan.index') }}">
                                <i class="bi bi-person-badge me-3 fs-5"></i>
                                <span>Data Dosen</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.appointments.*') ? 'active' : '' }}" href="{{ route('mahasiswa.appointments.index') }}">
                                <i class="bi bi-calendar3 me-3 fs-5"></i>
                                <span>Jadwal Bimbingan</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}" href="{{ route('admin.mahasiswa.index') }}">
                                <i class="bi bi-people me-3 fs-5"></i>
                                <span>Data Mahasiswa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}" href="{{ route('admin.dosen.index') }}">
                                <i class="bi bi-person-badge me-3 fs-5"></i>
                                <span>Data Dosen</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.periods') || request()->routeIs('admin.periods.*') ? 'active' : '' }}" href="{{ route('admin.periods') }}">
                                <i class="bi bi-calendar-range me-3 fs-5"></i>
                                <span>Periode Jadwal</span>
                            </a>
                        </li>
                    @endif
                    
                </ul>
            </aside>
        @endauth

        <main class="content-area">
            <div class="flex-grow-1">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <footer class="footer text-center">
                <div class="container">
                    <p class="mb-0 fw-medium">&copy; {{ date('Y') }} Universitas Jember &bull; Sistem Bimbingan Tugas Akhir.</p>
                </div>
            </footer>
        </main>
    </div>

        @auth
            @php
                $user = auth()->user();
                $userProdi = 'Sistem Informasi'; // default
                if ($user->role === 'dosen') {
                    $nip = $user->nim_nip;
                    $rumpunSI = [
                        '198706192014041001', '197904292008122002', '198110202014042001', 
                        '198511282015041002', '199110172020121002', '199512092022032023', 
                        '199208222022032014', '199503152023212038', '197604252023211002', 
                        '199412282024062001', '199907192024062001', '199202112024061001', 
                        '199008292025062003', '200001162025062013', '199809192025062010'
                    ];
                    $rumpunTI = [
                        '197004221995121001', '198603052014042001', '196811131994121001', 
                        '196906151997021002', '198201012010121004', '197803302003121003', 
                        '198403052010122002', '198301312015041001', '198411012015042001', 
                        '199011112019031018', '199206302022031009', '199112132023211015', 
                        '198511272023211013', '199508242024061001', '199803082024061001', 
                        '199609092025061007'
                    ];
                    if (in_array($nip, $rumpunSI)) {
                        $userProdi = 'Sistem Informasi';
                    } elseif (in_array($nip, $rumpunTI)) {
                        $userProdi = 'Teknologi Informasi';
                    } else {
                        $userProdi = 'Informatika';
                    }
                } elseif ($user->role === 'mahasiswa') {
                    $nim = $user->nim_nip;
                    if (str_contains($nim, '10101')) {
                        $userProdi = 'Sistem Informasi';
                    } elseif (str_contains($nim, '10102')) {
                        $userProdi = 'Teknologi Informasi';
                    } elseif (str_contains($nim, '10103')) {
                        $userProdi = 'Informatika';
                    } else {
                        $userProdi = 'Sistem Informasi';
                    }
                } else {
                    if (str_contains($user->email, 'sisteminformasi')) {
                        $userProdi = 'Sistem Informasi';
                    } elseif (str_contains($user->email, 'teknologiinformasi')) {
                        $userProdi = 'Teknologi Informasi';
                    } elseif (str_contains($user->email, 'informatika')) {
                        $userProdi = 'Informatika';
                    } else {
                        $userProdi = 'Program Studi';
                    }
                }
            @endphp

            <!-- Modal Edit Profil & Ubah Password -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content shadow-lg" style="border-radius: 16px; overflow: hidden; border: none;">
                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #02023e 0%, #005f92 100%); padding: 20px 24px; border-bottom: none;">
                            <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="editProfileModalLabel">
                                <i class="bi bi-person-gear fs-4"></i> Pengaturan Profil & Keamanan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(1) brightness(2);"></button>
                        </div>
                        
                        <form action="{{ route('profile.password.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body p-4">
                                <div class="row g-4">
                                    <!-- Left Side: Profile Preview (Read-Only) -->
                                    <div class="col-md-5 border-end text-center d-flex flex-column align-items-center justify-content-center py-3">
                                        <div class="d-inline-flex align-items-center justify-content-center text-white shadow-sm mb-3 position-relative overflow-hidden" 
                                             style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #02023e 0%, #005f92 100%); border: 3px solid rgba(255, 255, 255, 0.8);">
                                            <img id="profile-preview-img" src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : '' }}" 
                                                 class="{{ auth()->user()->photo ? '' : 'd-none' }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                            <i id="profile-preview-placeholder" class="bi bi-person-fill {{ auth()->user()->photo ? 'd-none' : '' }}" style="font-size: 4.5rem;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h5>
                                        <span class="badge bg-primary-subtle text-primary text-uppercase px-3 py-1.5 rounded-pill mb-3" style="font-size: 0.75rem;">
                                            {{ auth()->user()->role === 'admin' ? 'Kepala Prodi' : auth()->user()->role }}
                                        </span>
                                        
                                        <div class="w-100 text-start px-3 mt-2">
                                            <div class="mb-2.5 pb-2 border-bottom">
                                                <small class="text-muted d-block small uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">NIM / NIP</small>
                                                <span class="fw-semibold text-dark">{{ auth()->user()->nim_nip ?? '-' }}</span>
                                            </div>
                                            @if(auth()->user()->role !== 'admin' || $userProdi !== 'Program Studi')
                                                <div class="mb-2.5 pb-2 border-bottom">
                                                    <small class="text-muted d-block small uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Program Studi</small>
                                                    <span class="fw-semibold text-dark">{{ $userProdi }}</span>
                                                </div>
                                            @endif
                                            <div class="mb-0">
                                                <small class="text-muted d-block small uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Email Unej</small>
                                                <span class="fw-semibold text-dark text-break">{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Side: Edit Profile Photo & Password -->
                                    <div class="col-md-7">
                                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-bounding-box text-primary me-1"></i> Edit Foto Profil</h6>
                                        <div class="mb-4">
                                            <label for="profile_photo" class="form-label fw-semibold text-secondary small">Unggah Foto Profil Baru</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-image text-muted"></i></span>
                                                <input type="file" name="photo" id="profile_photo" class="form-control" accept="image/*" onchange="previewProfilePhoto(this)">
                                            </div>
                                            <div class="form-text text-muted" style="font-size: 0.75rem;">Format JPG, JPEG, PNG, GIF. Maksimal 2MB.</div>
                                        </div>

                                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-lock-fill text-primary me-1"></i> Ubah Password Keamanan <span class="text-muted fw-normal" style="font-size: 0.75rem;">(Opsional)</span></h6>
                                        <p class="text-secondary small mb-4">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password keamanan Anda.</p>
                                        
                                        @if ($errors->any())
                                            <div class="alert alert-danger p-2.5 mb-3" style="border-radius: 10px; font-size: 0.85rem;">
                                                <ul class="mb-0 ps-3">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="current_password" class="form-label fw-semibold text-secondary small">Password Saat Ini</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key-fill text-muted"></i></span>
                                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Masukkan password lama">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-semibold text-secondary small">Password Baru</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock-fill text-muted"></i></span>
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 6 karakter">
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <label for="password_confirmation" class="form-label fw-semibold text-secondary small">Konfirmasi Password Baru</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-check text-muted"></i></span>
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between p-4 bg-light border-top" style="border-radius: 0 0 16px 16px;">
                                <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">Batal</button>
                                <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 10px; font-weight: 600; background: var(--theme-blue-grad);">
                                    <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Preview selected profile photo
            window.previewProfilePhoto = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var previewImg = document.getElementById('profile-preview-img');
                        var previewPlaceholder = document.getElementById('profile-preview-placeholder');
                        if (previewImg && previewPlaceholder) {
                            previewImg.src = e.target.result;
                            previewImg.classList.remove('d-none');
                            previewPlaceholder.classList.add('d-none');
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };

            document.addEventListener('DOMContentLoaded', function() {
                // Loader Global logic
                const loader = document.getElementById('global-loader');

                // Expose a global function so any custom JS can show the loader
                window.showLoader = function() {
                    if (loader) loader.classList.remove('d-none');
                };
                window.hideLoader = function() {
                    if (loader) loader.classList.add('d-none');
                };
                
                // Hide loader after page is completely loaded
                window.addEventListener('load', function() {
                    if (loader) {
                        loader.classList.add('d-none');
                    }
                });

                // Catch ALL page navigations (including onclick="window.location.href=...")
                // This is the most reliable way to show loader for ANY navigation
                window.addEventListener('beforeunload', function() {
                    if (loader) {
                        loader.classList.remove('d-none');
                    }
                });
                
                // Event delegation for general links
                document.body.addEventListener('click', function(e) {
                    const link = e.target.closest('a');
                    if (!link) return;

                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');
                    const isDropdown = link.classList.contains('dropdown-toggle') || link.getAttribute('data-bs-toggle') === 'dropdown';
                    const isTab = link.getAttribute('data-bs-toggle') || link.getAttribute('data-toggle');

                    if (href && 
                        href !== '#' && 
                        !href.startsWith('#') && 
                        !href.startsWith('javascript:') && 
                        target !== '_blank' && 
                        !isDropdown && 
                        !isTab &&
                        !link.classList.contains('btn-confirm') &&
                        !e.defaultPrevented) {
                        
                        if (loader) {
                            loader.classList.remove('d-none');
                        }
                    }
                });

                // Event delegation for forms
                document.body.addEventListener('submit', function(e) {
                    const form = e.target;
                    if (form.getAttribute('target') === '_blank') return;
                    
                    // Do not show loader if HTML5 form validation fails
                    if (form.checkValidity && !form.checkValidity()) {
                        return;
                    }

                    if (loader) {
                        loader.classList.remove('d-none');
                    }
                });

                // Handle back/forward cache restore to hide loader
                window.addEventListener('pageshow', function(event) {
                    if (loader) {
                        loader.classList.add('d-none');
                    }
                });

                // Intercept form submissions or direct link actions via btn-confirm
                document.body.addEventListener('click', function(e) {
                    const btn = e.target.closest('.btn-confirm');
                    if (btn) {
                        e.preventDefault();
                        const form = btn.closest('form');
                        const message = btn.getAttribute('data-message') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                        const title = btn.getAttribute('data-title') || 'Konfirmasi Tindakan';
                        const confirmText = btn.getAttribute('data-confirm-text') || 'Ya, Lanjutkan';
                        const cancelText = btn.getAttribute('data-cancel-text') || 'Batal';
                        const icon = btn.getAttribute('data-icon') || 'warning';

                        Swal.fire({
                            title: title,
                            text: message,
                            icon: icon,
                            showCancelButton: true,
                            confirmButtonColor: '#2563eb',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: '<i class="bi bi-check-circle me-1"></i> ' + confirmText,
                            cancelButtonText: cancelText,
                            reverseButtons: true,
                            background: '#ffffff',
                            customClass: {
                                popup: 'rounded-4 shadow-lg border-0',
                                title: 'fw-bold text-dark fs-5 pt-3',
                                htmlContainer: 'text-secondary fs-6',
                                confirmButton: 'btn btn-primary px-4 py-2 me-2',
                                cancelButton: 'btn btn-secondary px-4 py-2'
                            },
                            buttonsStyling: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (form) {
                                    // Add a temporary hidden input to make sure submit triggers correctly if needed
                                    form.submit();
                                } else if (btn.tagName === 'A') {
                                    window.location.href = btn.href;
                                }
                            }
                        });
                    }
                });

                // Auto open edit profile modal if there are errors from the password update
                @if(Auth::check() && ($errors->has('current_password') || $errors->has('password')))
                    var editProfileModalEl = document.getElementById('editProfileModal');
                    if (editProfileModalEl) {
                        var editProfileModal = new bootstrap.Modal(editProfileModalEl);
                        editProfileModal.show();
                    }
                @endif
            });
        </script>
        @stack('scripts')
    </body>
    </html>