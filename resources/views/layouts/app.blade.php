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

    <style>
        :root {
            --theme-bg: #F1F5F9;
            --theme-navy-grad: linear-gradient(135deg, #03045E 0%, #0077B6 50%, #00B4D8 100%);
            --theme-blue-grad: linear-gradient(135deg, #0077B6 0%, #00B4D8 100%);
            --theme-card: #ffffff;
            --theme-text: #1E293B;
            --card-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--theme-bg);
            color: var(--theme-text);
            overflow: hidden;
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
            width: 290px;
            background: var(--theme-navy-grad);
            padding: 24px 16px;
            overflow-y: auto;
        }

        .sidebar-modern .nav-link {
            color: #CBD5E1 !important;
            padding: 16px 18px;
            border-radius: 18px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            font-size: 1.05rem;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar-modern .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: white !important;
            transform: translateX(4px);
        }

        .sidebar-modern .nav-link.active {
            background: rgba(255,255,255,0.12);
            color: white !important;
            border-left: 5px solid #90E0EF;
            font-weight: 700;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 32px;
            background: #F8FAFC;
        }

        .card {
            background: white;
            border: none;
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            padding: 24px;
        }

        .btn-unej-primary {
            background: var(--theme-blue-grad);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 12px 24px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-unej-primary:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .footer {
            margin-top: 20px;
            padding: 20px;
            color: #64748B;
        }
    </style>

    @stack('styles')
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-unej">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <span class="text-info"><i class="bi bi-mortarboard-fill"></i></span>
                <span>SIM-TA UNEJ</span>
            </a>

            <div class="ms-auto">
                @auth
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 text-light"></i>
                            <span class="text-white fw-medium">{{ auth()->user()->name }}</span>
                            <span class="badge bg-light text-dark text-uppercase fs-7 ms-1" style="padding: 3px 8px; border-radius: 6px;">{{ auth()->user()->role }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
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
                            <a class="nav-link {{ request()->routeIs('admin.periods.*') ? 'active' : '' }}" href="{{ route('admin.periods') }}">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>