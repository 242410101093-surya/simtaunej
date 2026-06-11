<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Bimbingan;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            $totalMahasiswa = User::where('role', 'mahasiswa')->count();
            $totalDosen     = User::where('role', 'dosen')->count();
            $totalBimbingan = Bimbingan::count();
            $bimbinganPending = Bimbingan::where('status', 'pending')->count();
            $recentBimbingan  = Bimbingan::with(['mahasiswa', 'dosen'])->orderBy('tanggal_upload', 'desc')->take(5)->get();
            $mahasiswa        = User::where('role', 'mahasiswa')->with(['statusMahasiswa'])->orderBy('created_at', 'desc')->get();
            $recentUsers      = User::orderBy('created_at', 'desc')->take(5)->get();
            $mahasiswaLayakSempro = DB::table('status_mahasiswa')->where('layak_sempro', 1)->count();
            $mahasiswaLayakSidang  = DB::table('status_mahasiswa')->where('layak_sidang', 1)->count();
        } catch (\Exception $e) {
            $totalMahasiswa = $totalDosen = $totalBimbingan = $bimbinganPending = 0;
            $recentBimbingan = collect([]);
            $mahasiswa = collect([]);
            $recentUsers = collect([]);
            $mahasiswaLayakSempro = 0;
            $mahasiswaLayakSidang  = 0;
        }

        return view('admin.dashboard', compact(
            'totalMahasiswa', 'totalDosen', 'totalBimbingan',
            'bimbinganPending', 'recentUsers', 'recentBimbingan',
            'mahasiswa', 'mahasiswaLayakSempro', 'mahasiswaLayakSidang'
        ));
    }

    // --- MANAJEMEN MAHASISWA ---
    public function indexMahasiswa()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->with(['dosenPembimbing', 'statusMahasiswa'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function createMahasiswa()
    {
        return view('admin.mahasiswa.create');
    }

    public function storeMahasiswa(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nim_nip'  => 'nullable|string|max:50',
            'phone'    => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'mahasiswa',
            'nim_nip'  => $validated['nim_nip'] ?? null,
            'phone'    => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function showMahasiswa($id)
    {
        $mahasiswa = User::findOrFail($id);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    // --- MANAJEMEN DOSEN (Fixed: Menyediakan $prodiSelected & prodi_asal) ---
    public function indexDosen(Request $request)
    {
        // Tangkap parameter prodi untuk inisialisasi awal UI Blade
        $prodiSelected = $request->query('prodi', 'Sistem Informasi');
        
        // Penyelaras jika text dikirim dari link dalam format bahasa Inggris
        if ($prodiSelected === 'Sistem Information') {
            $prodiSelected = 'Sistem Informasi';
        }

        // Ambil data dosen beserta hitungan bimbingan mahasiswa secara real-time
        $dosen = User::where('role', 'dosen')
            ->withCount(['bimbingans as mahasiswa_bimbingan_count'])
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($user) {
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

                // Inject properti prodi_asal secara dinamis agar terbaca oleh JavaScript Client-Side
                if (in_array($nip, $rumpunSI)) {
                    $user->prodi_asal = 'Sistem Informasi';
                } elseif (in_array($nip, $rumpunTI)) {
                    $user->prodi_asal = 'Teknologi Informasi';
                } else {
                    $user->prodi_asal = 'Informatika';
                }

                $user->phone = $user->phone ?? '-';

                return $user;
            });

        return view('admin.dosen.index', compact('dosen', 'prodiSelected'));
    }

    public function createDosen()
    {
        return view('admin.dosen.create');
    }

    public function storeDosen(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nim_nip'  => 'required|string|max:50|unique:users,nim_nip',
            'phone'    => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'dosen',
            'nim_nip'  => $validated['nim_nip'],
            'phone'    => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function showDosen($id)
    {
        $dosen = User::findOrFail($id);
        return view('admin.dosen.show', compact('dosen'));
    }

    // --- MANAJEMEN PERIODE (Fixed: Terhubung Otomatis ke Database Berdasarkan Skema Tabel) ---
    public function periods()
    {
        // Menggunakan data real dari tabel schedule_periods di database Anda
        $periods = DB::table('schedule_periods')->orderBy('id', 'desc')->get();
        return view('admin.periods.index', compact('periods'));
    }

    public function createPeriod()
    {
        return view('admin.periods.create');
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'period_name' => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);
        
        DB::table('schedule_periods')->insert([
            'period_name'           => $request->period_name,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'registration_deadline' => $request->start_date,
            'description'           => $request->description,
            'is_active'             => 1,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        return redirect()->route('admin.periods')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    public function editPeriod($id)
    {
        $period = DB::table('schedule_periods')->where('id', $id)->firstOrFail();
        return view('admin.periods.edit', compact('period', 'id'));
    }

    public function updatePeriod(Request $request, $id)
    {
        $request->validate([
            'period_name' => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        DB::table('schedule_periods')->where('id', $id)->update([
            'period_name' => $request->period_name,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'description' => $request->description,
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.periods')
            ->with('success', 'Periode berhasil diperbarui.');
    }

    public function deletePeriod($id)
    {
        DB::table('schedule_periods')->where('id', $id)->delete();
        return redirect()->route('admin.periods')
            ->with('success', 'Periode berhasil dihapus.');
    }

    public function laporan()
    {
        return view('admin.reports.laporan');
    }

    public function reports()
    {
        return view('admin.reports.index');
    }
}