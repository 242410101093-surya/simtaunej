<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Bimbingan Tugas Akhir UNEJ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ url('/logo-unej.png') }}">

    <style>
        :root {
            --theme-navy: #02023e;
            --theme-blue: #005f92;
            --theme-dark-blue: #004b75;
            --theme-light: #f8f9fa;
            --theme-navy-grad: linear-gradient(135deg, #02023e 0%, #005f92 100%);
            --theme-blue-grad: linear-gradient(135deg, #005f92 0%, #004b75 100%);
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }

        body {
            background: linear-gradient(135deg, var(--theme-navy), var(--theme-blue), var(--theme-dark-blue), var(--theme-blue));
            background-size: 300% 300%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            animation: oceanWave 10s ease-in-out infinite;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
            z-index: 1;
            pointer-events: none;
        }

        .bg-glow-1 {
            position: fixed;
            width: 500px;
            height: 500px;
            top: -150px;
            right: -100px;
            background: radial-gradient(circle, rgba(0, 180, 216, 0.25) 0%, transparent 70%);
            z-index: 1;
            pointer-events: none;
            filter: blur(50px);
        }

        .bg-glow-2 {
            position: fixed;
            width: 600px;
            height: 600px;
            bottom: -200px;
            left: -150px;
            background: radial-gradient(circle, rgba(2, 2, 62, 0.4) 0%, transparent 70%);
            z-index: 1;
            pointer-events: none;
            filter: blur(50px);
        }

        .container {
            position: relative;
            z-index: 2;
        }

        @keyframes oceanWave {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(2, 2, 62, 0.4);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }

        .login-header {
            background: var(--theme-navy-grad);
            color: white;
            padding: 35px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: rgba(0, 95, 146, 0.3);
            border-radius: 50%;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 10px;
            display: block;
            color: #ffffff;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
            position: relative;
            z-index: 2;
        }

        .login-header h3 {
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
            z-index: 2;
            letter-spacing: 0.5px;
        }

        .login-header p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.85;
            position: relative;
            z-index: 2;
        }

        .login-form {
            padding: 35px;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 11px 15px;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--theme-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 95, 146, 0.15);
            background-color: #f0f6fa;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-check-input:checked {
            background-color: var(--theme-blue);
            border-color: var(--theme-blue);
        }

        .btn-login {
            background: var(--theme-blue-grad);
            color: white;
            border: none;
            padding: 12px 35px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
            font-size: 1rem;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(0, 95, 146, 0.25);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 95, 146, 0.4);
            color: white;
        }

        .input-group-text {
            background-color: var(--theme-light);
            border: 1.5px solid #e2e8f0;
            color: var(--theme-blue);
        }

        .alert {
            border-radius: 10px;
            border: none;
            border-left: 4px solid;
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(0, 200, 83, 0.15), rgba(0, 200, 83, 0.05));
            color: #00c853;
            border-left-color: #00c853;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.15), rgba(230, 57, 70, 0.05));
            color: #e63946;
            border-left-color: #e63946;
        }

        .switch-to-register {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .switch-to-register a {
            color: var(--theme-blue);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .switch-to-register a:hover {
            color: var(--theme-navy);
            text-decoration: underline;
        }

        .social-links a {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.5rem;
            transition: all 0.3s;
        }
        .social-links a:hover {
            color: #ffffff;
            transform: scale(1.1);
        }

        /* Variasi Background Modern */
        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite linear;
            pointer-events: none;
            z-index: 1;
        }

        .shape-1 { width: 150px; height: 150px; top: 10%; left: 5%; animation-duration: 20s; animation-delay: 0s; }
        .shape-2 { width: 250px; height: 250px; top: 60%; left: 15%; animation-duration: 25s; animation-delay: -5s; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        .shape-3 { width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 15s; animation-delay: -2s; }
        .shape-4 { width: 200px; height: 200px; bottom: 10%; right: 5%; animation-duration: 22s; animation-delay: -10s; border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        .shape-5 { width: 80px; height: 80px; top: 40%; left: 50%; animation-duration: 18s; animation-delay: -8s; }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
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
</head>
<body>
    <!-- Global Loader Overlay -->
    <div id="global-loader" class="global-loader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <div class="loader-text">LOADING...</div>
        </div>
    </div>

    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>
    
    <!-- Floating Elements -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    <div class="floating-shape shape-4"></div>
    <div class="floating-shape shape-5"></div>

    <div class="container px-4 px-md-5">
        <div class="row align-items-center justify-content-center m-0 min-vh-100 g-4 g-md-5">
            
            <div class="col-md-6 col-lg-6 text-white mb-4 mb-md-0 d-flex flex-column justify-content-center align-items-start ps-md-0">
                <div class="mb-4 bg-white bg-opacity-10 d-flex align-items-center justify-content-center rounded-4 p-2 shadow-sm" style="width: 75px; height: 75px; border: 1px solid rgba(255,255,255,0.15);">
                    <img src="{{ url('/logo-unej.png') }}" alt="Logo UNEJ" style="height: 55px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                </div>
                
                <h1 class="fw-bold mb-3 display-3" style="letter-spacing: -2px;">SELAMAT DATANG</h1>
                
                <p class="fs-5 text-white bg-opacity-75 mb-4 lh-base" style="max-width: 550px;">
                    Selangkah lebih dekat menuju gelar sarjana. <br>
                    Tetap semangat dan tuntaskan bimbingan tugas akhirmu!
                </p>
                
                <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10 w-100 mb-4" style="max-width: 500px;">
                    <h6 class="fw-bold mb-3 text-warning"><i class="bi bi-award-fill me-2"></i> Lulus Tepat Waktu dengan SIM-TA</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small mb-0">
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill text-info mt-1"></i>
                            <span>Bimbingan Tugas Akhir online terstruktur langsung dengan Dosen Pembimbing.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill text-info mt-1"></i>
                            <span>Pengarsipan draft revisi dokumen proposal & skripsi yang rapi dan aman.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill text-info mt-1"></i>
                            <span>Booking jadwal bimbingan tatap muka secara efisien tanpa bentrok jadwal.</span>
                        </li>
                    </ul>
                </div>
                
                <div class="w-70 border-top border-white border-opacity-25 pt-3 mb-4">
                    <small class="text-white-50 d-block">Sistem Bimbingan Tugas Akhir - Universitas Jember</small>
                </div>

                <div class="d-flex gap-3 social-links">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 d-flex justify-content-center align-items-center">
                <div class="login-container">
                    <div class="login-header">
                        <img src="{{ url('/logo-unej.png') }}" alt="Logo UNEJ" style="height: 60px; width: auto; margin-bottom: 12px; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.2));">
                        <h3>Masuk Sekarang</h3>
                        <p>SIM-TA UNEJ</p>
                    </div>

                    <div class="login-form">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <ul class="mb-0 ps-3 mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Pengguna</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" 
                                           placeholder="email@example.com" required autofocus>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control" 
                                           id="password" name="password" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label text-muted small" for="remember">
                                        Ingat Saya
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sekarang
                            </button>

                            <div class="switch-to-register">
                                <small class="text-muted">
                                    Belum memiliki akun? 
                                    <a href="{{ route('register') }}">
                                        <i class="bi bi-person-plus-fill"></i> Daftar di sini
                                    </a>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('global-loader');
            
            // Hide loader after page is completely loaded
            window.addEventListener('load', function() {
                if (loader) {
                    loader.classList.add('d-none');
                }
            });
            
            // Event delegation for links
            document.body.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;

                const href = link.getAttribute('href');
                const target = link.getAttribute('target');

                if (href && 
                    href !== '#' && 
                    !href.startsWith('#') && 
                    !href.startsWith('javascript:') && 
                    target !== '_blank' && 
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
        });
    </script>
</body>
</html>