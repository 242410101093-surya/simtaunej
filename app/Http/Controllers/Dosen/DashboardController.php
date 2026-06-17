<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        // 1. Statistik dashboard
        $totalMahasiswa = DB::table('bimbingans')
            ->where('dosen_id', $dosenId)
            ->distinct('mahasiswa_id')
            ->count();

        $pendingReview = DB::table('bimbingans')
            ->where('dosen_id', $dosenId)
            ->where('status', 'pending')
            ->count();

        // 2. Riwayat bimbingan terbaru
        $recentBimbingan = \App\Models\Bimbingan::where('dosen_id', $dosenId)
            ->with('mahasiswa')
            ->orderBy('tanggal_upload', 'desc')
            ->take(5)
            ->get();

        // 3. Mahasiswa bimbingan — gabungan dari mahasiswa_dosen dan bimbingans
        $mahasiswaIds = DB::table('mahasiswa_dosen')
            ->where('dosen_id', $dosenId)
            ->pluck('mahasiswa_id')
            ->merge(
                DB::table('bimbingans')
                    ->where('dosen_id', $dosenId)
                    ->distinct()
                    ->pluck('mahasiswa_id')
            )
            ->unique()
            ->values();

        $mahasiswaBimbingan = \App\Models\User::whereIn('id', $mahasiswaIds)
            ->with('statusMahasiswa')
            ->take(6)
            ->get();

        // 4. Pending review
        $bimbinganPending = \App\Models\Bimbingan::where('dosen_id', $dosenId)
            ->where('status', 'pending')
            ->with('mahasiswa')
            ->get();

        // 5. Appointments pending
        $appointments = Appointment::where('dosen_id', $dosenId)
            ->where('status', 'pending')
            ->with('mahasiswa')
            ->get();

        // 6. Jadwal bimbingan mendatang (approved)
        $nowDate = \Carbon\Carbon::now()->toDateString();
        $nowTime = \Carbon\Carbon::now()->format('H:i:s');

        $upcomingAppointments = Appointment::where('dosen_id', $dosenId)
            ->where('status', 'approved')
            ->where(function ($query) use ($nowDate, $nowTime) {
                $query->where('scheduled_date', '>', $nowDate)
                      ->orWhere(function ($q) use ($nowDate, $nowTime) {
                          $q->where('scheduled_date', '=', $nowDate)
                            ->where('scheduled_time', '>=', $nowTime);
                      });
            })
            ->with('mahasiswa')
            ->orderBy('scheduled_date', 'asc')
            ->orderBy('scheduled_time', 'asc')
            ->take(5)
            ->get();

        return view('dosen.dashboard', compact(
            'totalMahasiswa',
            'pendingReview',
            'recentBimbingan',
            'mahasiswaBimbingan',
            'bimbinganPending',
            'appointments',
            'upcomingAppointments'
        ));
    }
}