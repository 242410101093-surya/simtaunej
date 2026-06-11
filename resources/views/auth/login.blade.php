<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Bimbingan Tugas Akhir UNEJ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

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
    </style>
</head>
<body>

    <div class="container px-4 px-md-5">
        <div class="row align-items-center justify-content-center m-0 min-vh-100 g-4 g-md-5">
            
            <div class="col-md-6 col-lg-6 text-white mb-4 mb-md-0 d-flex flex-column justify-content-center align-items-start ps-md-0">
                <div class="mb-4 bg-white bg-opacity-10 d-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px;">
                    <i class="bi bi-shield-lock-fill text-white" style="font-size: 2.2rem;"></i>
                </div>
                
                <h1 class="fw-bold mb-3 display-3" style="letter-spacing: -1px;">SELAMAT DATANG</h1>
                
                <p class="fs-5 text-white bg-opacity-75 mb-4 lh-base" style="max-width: 550px;">
                    Selangkah lebih dekat menuju gelar sarjana. <br>
                    Tetap semangat dan tuntaskan bimbingan tugas akhirmu!
                </p>
                
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
                        <i class="bi bi-box-arrow-in-right"></i>
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
</body>
</html>