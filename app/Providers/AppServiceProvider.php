<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // PAKET LENGKAP PENJINAK ERROR STATISTIK SIDEBAR & LAYOUT
        View::share('totalMahasiswa', 0);
        View::share('totalDosen', 0);
        View::share('totalBimbingan', 0);
        View::share('mahasiswaLayakSidang', 0); // <-- KITA AMANKAN VARIABEL INI JUGA
        View::share('pendingReview', 0);
        View::share('bimbinganPending', collect());
    }
}
