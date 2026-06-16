<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Bimbingan TA UNEJ</title>

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

        body {
            background: linear-gradient(135deg, var(--theme-navy), var(--theme-blue), var(--theme-dark-blue), var(--theme-blue));
            background-size: 300% 300%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
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

        .register-container {
            background: white;
            border-radius: 20px; /* Diperhalus sudut lekukannya */
            box-shadow: 0 15px 40px rgba(3, 4, 94, 0.15);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
        }

        .register-header {
            /* Mengubah warna header atas menjadi gradasi dongker-biru modern */
            background: var(--theme-navy-grad);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(0, 180, 216, 0.2);
            border-radius: 50%;
        }

        .register-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .register-header i {
            font-size: 3.5rem;
            margin-bottom: 15px;
            display: block;
            color: #ffffff; /* Icon diubah menjadi putih bersih agar minimalis */
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
            position: relative;
            z-index: 2;
        }

        .register-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
            z-index: 2;
            letter-spacing: 0.5px;
        }

        .register-header p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.85;
            position: relative;
            z-index: 2;
        }

        .register-form {
            padding: 40px;
        }

        .form-section-title {
            /* Mengubah sub-judul data pribadi & keamanan menjadi biru */
            color: var(--theme-blue);
            font-weight: 700;
            font-size: 0.95rem;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--theme-cyan);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-section-title:first-child {
            margin-top: 0;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 11px 15px;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            /* Fokus border saat diklik diubah menjadi biru-cyan */
            border-color: var(--theme-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 119, 182, 0.15);
            background-color: #f0f7fa;
        }

        .form-label {
            font-weight: 500;
            color: #333333;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-text {
            font-size: 0.8rem;
            margin-top: 5px;
            color: #6c757d;
        }

        .required {
            color: #e63946;
            font-weight: 600;
        }

        .btn-register {
            /* Mengubah tombol daftar menjadi gradasi biru cyan menawan */
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
            box-shadow: 0 4px 15px rgba(0, 119, 182, 0.25);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 119, 182, 0.4);
            color: white;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
        }

        .input-group-text {
            background-color: var(--theme-light);
            border: 1.5px solid #e2e8f0;
            color: var(--theme-blue); /* Icon input menjadi biru */
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .alert {
            border-radius: 10px;
            border: none;
            border-left: 4px solid;
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .info-box {
            /* Mengubah box informasi privasi menjadi gradasi selaras tema baru */
            background: var(--theme-navy-grad);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
            position: relative;
            overflow: hidden;
            border-left: 4px solid var(--theme-cyan);
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .info-box i {
            margin-right: 10px;
            font-size: 1.2rem;
            color: var(--theme-cyan);
            position: relative;
            z-index: 2;
        }

        .info-box p {
            position: relative;
            z-index: 2;
        }

        .back-to-login {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .back-to-login a {
            color: var(--theme-blue);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .back-to-login a:hover {
            color: var(--theme-navy);
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-header {
                padding: 30px 20px;
            }

            .register-header i {
                font-size: 2.5rem;
            }

            .register-form {
                padding: 25px;
            }
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="register-container">
                    <div class="register-header">
                        <i class="bi bi-person-plus-fill"></i>
                        <h2>Daftar Akun Baru</h2>
                        <p>Sistem Bimbingan Tugas Akhir - Universitas Jember</p>
                    </div>

                    <div class="register-form">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                <strong>Berhasil!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <strong>Perhatian!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="alert alert-info border-0 shadow-sm mb-4" style="background-color: #e0f2fe; color: #0369a1; border-radius: 12px; border-left: 4px solid #0284c7 !important;">
                            <div class="d-flex gap-2 align-items-start">
                                <i class="bi bi-info-circle-fill fs-5 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Panduan Registrasi SIM-TA:</span>
                                    <span class="d-block small mt-1">• Halaman ini hanya diperuntukkan bagi pendaftaran akun **Mahasiswa**.</span>
                                    <span class="d-block small mt-1">• Dosen dan Kepala Prodi tidak perlu mendaftar secara manual, silakan gunakan akun Anda untuk langsung login.</span>
                                    <span class="d-block small mt-1">• Pastikan email Universitas Jember Anda aktif untuk menerima notifikasi bimbingan.</span>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register') }}" novalidate>
                            @csrf

                            <div class="form-section-title">
                                <i class="bi bi-person-workspace"></i> Data Pribadi
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        Nama Lengkap <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}"
                                               placeholder="Nama lengkap Anda" required autofocus>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}"
                                               placeholder="email@example.com" required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        Nomor Telepon
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                               id="phone" name="phone" value="{{ old('phone') }}"
                                               placeholder="628xxxxxxxxxx">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nim_nip" class="form-label">
                                        NIM <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" class="form-control @error('nim_nip') is-invalid @enderror"
                                               id="nim_nip" name="nim_nip" value="{{ old('nim_nip') }}"
                                               placeholder="Masukkan NIM Anda" required>
                                        @error('nim_nip')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-section-title">
                                <i class="bi bi-shield-lock"></i> Keamanan
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        Password <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" placeholder="••••••••" required>
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle"></i> Minimal 6 karakter
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password-confirm" class="form-label">
                                        Konfirmasi Password <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" class="form-control"
                                               id="password-confirm" name="password_confirmation"
                                               placeholder="••••••••" required>
                                    </div>
                                </div>
                            </div>

                            <div class="info-box">
                                <i class="bi bi-lock-fill"></i>
                                <strong>Privasi & Keamanan</strong>
                                <p class="mb-0 mt-2" style="font-size: 0.9rem;">
                                    Data Anda akan disimpan dengan aman dan tidak akan dibagikan kepada pihak ketiga tanpa persetujuan.
                                </p>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-register">
                                    <i class="bi bi-person-plus-fill me-2"></i> Daftar Sekarang
                                </button>
                            </div>

                            <div class="back-to-login">
                                <small class="text-muted">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right"></i> Masuk di sini
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