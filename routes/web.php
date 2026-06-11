<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Mahasiswa\MahasiswaBimbinganController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Dosen\DosenBimbinganController;
use App\Http\Controllers\Dosen\DosenController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Dashboard umum & Profile (Authenticated)
Route::middleware(['auth'])->group(function () {

    // 👮 POLISI LALU LINTAS CADANGAN: Mencegah eror 'View [dashboard] not found'
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        } elseif ($user->role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }

        return redirect()->route('login');
    })->name('dashboard');

    // Quick Menu
    Route::get('/menu', [\App\Http\Controllers\MenuController::class, 'index'])
        ->name('menu');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    // Profile Edit
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/profile/password/edit', [ProfileController::class, 'editPassword'])
        ->name('profile.password.edit');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});

// ======================
// ADMIN ROUTES
// ======================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Mahasiswa
        Route::get('/mahasiswa', [\App\Http\Controllers\Admin\AdminController::class, 'indexMahasiswa'])
            ->name('mahasiswa.index');

        Route::get('/mahasiswa/create', [\App\Http\Controllers\Admin\AdminController::class, 'createMahasiswa'])
            ->name('mahasiswa.create');

        Route::post('/mahasiswa', [\App\Http\Controllers\Admin\AdminController::class, 'storeMahasiswa'])
            ->name('mahasiswa.store');

        Route::get('/mahasiswa/{mahasiswa}', [\App\Http\Controllers\Admin\AdminController::class, 'showMahasiswa'])
            ->name('mahasiswa.show');

        // Dosen
        Route::get('/dosen', [\App\Http\Controllers\Admin\AdminController::class, 'indexDosen'])
            ->name('dosen.index');

        Route::get('/dosen/create', [\App\Http\Controllers\Admin\AdminController::class, 'createDosen'])
            ->name('dosen.create');

        Route::post('/dosen', [\App\Http\Controllers\Admin\AdminController::class, 'storeDosen'])
            ->name('dosen.store');

        Route::get('/dosen/{dosen}', [\App\Http\Controllers\Admin\AdminController::class, 'showDosen'])
            ->name('dosen.show');

        // Period (DISINKRONKAN: Menggunakan parameter {id} agar pas dengan button edit/delete di Blade)
        Route::get('/periods', [\App\Http\Controllers\Admin\AdminController::class, 'periods'])
            ->name('periods');

        Route::get('/periods/create', [\App\Http\Controllers\Admin\AdminController::class, 'createPeriod'])
            ->name('periods.create');

        Route::post('/periods', [\App\Http\Controllers\Admin\AdminController::class, 'storePeriod'])
            ->name('periods.store');

        Route::get('/periods/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editPeriod'])
            ->name('periods.edit');

        Route::put('/periods/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'updatePeriod'])
            ->name('periods.update');

        Route::delete('/periods/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'deletePeriod'])
            ->name('periods.delete');

        // Reports
        Route::get('/laporan', [\App\Http\Controllers\Admin\AdminController::class, 'laporan'])
            ->name('laporan');

        Route::get('/reports', [\App\Http\Controllers\Admin\AdminController::class, 'reports'])
            ->name('reports');
    });
    
// ======================
// DOSEN ROUTES
// ======================
Route::middleware(['auth', 'role:dosen'])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {

        // Dashboard Dosen
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])
            ->name('dashboard');

        // Mahasiswa
        Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])
            ->name('mahasiswa.index');

        Route::get('/mahasiswa/{mahasiswa}', [DosenController::class, 'showMahasiswa'])
            ->name('mahasiswa.show');

        // Bimbingan
        Route::get('/bimbingan/{bimbingan}', [DosenController::class, 'showBimbingan'])
            ->name('bimbingan.show');

        Route::put('/bimbingan/{bimbingan}/status', [DosenController::class, 'updateBimbinganStatus'])
            ->name('bimbingan.update-status');

        // Submission Review
        Route::get('/submissions/{submission}/review', [DosenController::class, 'reviewSubmission'])
            ->name('submissions.review');

        Route::post('/submissions/{submission}/comment', [DosenController::class, 'addComment'])
            ->name('submissions.comment');

        Route::put('/submissions/{submission}/approve', [DosenController::class, 'approveSubmission'])
            ->name('submissions.approve');

        Route::put('/submissions/{submission}/reject', [DosenController::class, 'rejectSubmission'])
            ->name('submissions.reject');

        // History
        Route::get('/history', [DosenController::class, 'history'])
            ->name('history');

        // Legacy Routes
        Route::get('/mahasiswa-compat/{id}', [DosenBimbinganController::class, 'showMahasiswa'])
            ->name('mahasiswa.compat');

        Route::get('/bimbingan/{id}/review-compat', [DosenBimbinganController::class, 'reviewBimbingan'])
            ->name('bimbingan.review');

        Route::post('/bimbingan/{id}/review-compat', [DosenBimbinganController::class, 'submitReview'])
            ->name('bimbingan.submit-review');

        Route::post('/mahasiswa/{id}/approve-sempro-compat', [DosenBimbinganController::class, 'approveLayakSempro'])
            ->name('approve.sempro');

        Route::post('/mahasiswa/{id}/approve-sidang-compat', [DosenBimbinganController::class, 'approveLayakSidang'])
            ->name('approve.sidang');

        // Review Baru
        Route::get('/bimbingan/{id}/review', [DosenBimbinganController::class, 'reviewBimbingan'])
            ->name('bimbingan.review-new');

        Route::post('/bimbingan/comment-submission/{submissionId}', [DosenBimbinganController::class, 'commentOnSubmission'])
            ->name('bimbingan.comment-submission');

        // Appointments
        Route::get('/appointments', [DosenBimbinganController::class, 'appointmentRequests'])
            ->name('appointments.index');

        Route::post('/appointments/{id}/approve', [DosenBimbinganController::class, 'approveAppointment'])
            ->name('appointments.approve');

        Route::post('/appointments/{id}/reject', [DosenBimbinganController::class, 'rejectAppointment'])
            ->name('appointments.reject');

        Route::get('/schedule', [DosenBimbinganController::class, 'mySchedule'])
            ->name('schedule.my');
    });

// ======================
// MAHASISWA ROUTES
// ======================
Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])
            ->name('dashboard');

        // Bimbingan
        Route::get('/bimbingan', [MahasiswaController::class, 'bimbingan'])
            ->name('bimbingan.index');

        Route::get('/bimbingan/{bimbingan}', [MahasiswaController::class, 'showBimbingan'])
            ->whereNumber('bimbingan')
            ->name('bimbingan.show');

        // Upload
        Route::get('/bimbingan/{bimbingan}/upload', [MahasiswaController::class, 'uploadForm'])
            ->name('uploads.create');

        Route::post('/bimbingan/{bimbingan}/upload', [MahasiswaController::class, 'storeUpload'])
            ->name('uploads.store');

        Route::get('/bimbingan/upload', [MahasiswaBimbinganController::class, 'create'])
            ->name('bimbingan.create');

        Route::post('/bimbingan/upload', [MahasiswaBimbinganController::class, 'store'])
            ->name('bimbingan.store');

        // Submission
        Route::get('/submissions/{submission}', [MahasiswaController::class, 'showSubmission'])
            ->name('submissions.show');

        // Progress
        Route::get('/progress', [MahasiswaController::class, 'progress'])
            ->name('progress');

        // Archive
        Route::get('/bimbingan/{bimbingan}/archive/download', [MahasiswaController::class, 'downloadArchive'])
            ->name('archive.download');

        // Legacy
        Route::get('/bimbingan-compat/{id}', [MahasiswaBimbinganController::class, 'show'])
            ->name('bimbingan.compat');

        Route::get('/bimbingan-compat/{id}/download', [MahasiswaBimbinganController::class, 'download'])
            ->name('bimbingan.download');

        Route::get('/riwayat-compat/export', [MahasiswaBimbinganController::class, 'exportHistory'])
            ->name('riwayat.export');

        // Appointments
        Route::get('/appointments', [MahasiswaBimbinganController::class, 'appointmentsIndex'])
            ->name('appointments.index');

        // Rute appointments.create pengaman cadangan
        Route::get('/appointments/create', [MahasiswaBimbinganController::class, 'appointmentsIndex'])
            ->name('appointments.create');

        Route::post('/appointments/book', [MahasiswaBimbinganController::class, 'bookAppointment'])
            ->name('appointments.book');

        Route::get('/appointments/my', [MahasiswaBimbinganController::class, 'myAppointments'])
            ->name('appointments.my');

        Route::post('/appointments/{id}/cancel', [MahasiswaBimbinganController::class, 'cancelAppointment'])
            ->name('appointments.cancel');
    });