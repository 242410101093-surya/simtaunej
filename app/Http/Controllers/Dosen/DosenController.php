<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\SubmissionFile;
use App\Models\Comment;
use App\Models\Appointment; 
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan facade DB

class DosenController extends Controller
{
    public function dashboard(): View
    {
        $dosen = Auth::user();
        $dosenId = $dosen->id;

        // PERBAIKAN 1: Menghitung total mahasiswa bimbingan resmi dari tabel mahasiswa_dosen
        $totalMahasiswa = DB::table('mahasiswa_dosen')
            ->where('dosen_id', $dosenId)
            ->count();

        // PERBAIKAN 2: Mengambil bimbingan pending melalui relasi mahasiswa_dosen (karena di tabel bimbingans tidak ada dosen_id)
        $bimbinganPending = Bimbingan::whereIn('mahasiswa_id', function($query) use ($dosenId) {
                $query->select('mahasiswa_id')->from('mahasiswa_dosen')->where('dosen_id', $dosenId);
            })
            ->where('status', 'pending')
            ->with(['mahasiswa', 'submissionFiles'])
            ->latest('created_at')
            ->get();

        $pendingReview = SubmissionFile::where('dosen_id', $dosenId)
            ->where('status', 'submitted')
            ->count();

        // PERBAIKAN 3: Mengambil list mahasiswa bimbingan resmi dari tabel mahasiswa_dosen
        $mahasiswaBimbingan = User::where('role', 'mahasiswa')
            ->whereIn('id', function($query) use ($dosenId) {
                $query->select('mahasiswa_id')->from('mahasiswa_dosen')->where('dosen_id', $dosenId);
            })->with(['statusMahasiswa'])->get();

        // PERBAIKAN 4: Riwayat bimbingan terbaru difilter berdasarkan mahasiswa bimbingan dosen ini
        $recentBimbingan = Bimbingan::whereIn('mahasiswa_id', function($query) use ($dosenId) {
                $query->select('mahasiswa_id')->from('mahasiswa_dosen')->where('dosen_id', $dosenId);
            })
            ->with(['mahasiswa', 'submissionFiles.comments'])
            ->latest('created_at')
            ->limit(10)
            ->get();

        $appointments = Appointment::where('dosen_id', $dosenId)
            ->where('status', 'pending')
            ->with('mahasiswa')
            ->get();

        return view('dosen.dashboard', compact(
            'totalMahasiswa', 'pendingReview', 'bimbinganPending',
            'mahasiswaBimbingan', 'recentBimbingan', 'appointments'
        ));
    }

    public function mahasiswa(): View
    {
        $dosenId = Auth::id();

        // Cari mahasiswa yang terdaftar via mahasiswa_dosen ATAU pernah upload bimbingan ke dosen ini
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

        $mahasiswa = User::where('role', 'mahasiswa')
            ->whereIn('id', $mahasiswaIds)
            ->with('statusMahasiswa')
            ->paginate(15);

        return view('dosen.mahasiswa.index', compact('mahasiswa'));
    }

    public function showMahasiswa(User $mahasiswa): View
    {
        $dosenId = Auth::id();

        // Validasi: mahasiswa harus ada di mahasiswa_dosen ATAU pernah upload bimbingan ke dosen ini
        $inMahasiswaDosen = DB::table('mahasiswa_dosen')
            ->where('dosen_id', $dosenId)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->exists();

        $inBimbingans = DB::table('bimbingans')
            ->where('dosen_id', $dosenId)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->exists();

        if (!$inMahasiswaDosen && !$inBimbingans) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini');
        }

        // Mengambil data bimbingan mahasiswa
        $bimbingan = Bimbingan::where('mahasiswa_id', $mahasiswa->id)
            ->with(['submissionFiles.comments'])
            ->latest('created_at')
            ->paginate(10);

        return view('dosen.mahasiswa.dosen lihat detail mahasiswa', compact('mahasiswa', 'bimbingan'));
    }

    public function showBimbingan(Bimbingan $bimbingan): View
    {
        // Pastikan Policy view disesuaikan atau matikan sementara jika bermasalah
        $this->authorize('view', $bimbingan);

        $submissions = $bimbingan->submissionFiles()
            ->with(['mahasiswa', 'comments.dosen'])
            ->latest('created_at')
            ->get();

        return view('dosen.Bimbingan.show', compact('bimbingan', 'submissions'));
    }

    public function reviewSubmission(SubmissionFile $submission): View
    {
        $this->authorize('review', $submission);

        $comments = $submission->comments()
            ->with('dosen')
            ->orderBy('is_pinned', 'desc')
            ->latest('created_at')
            ->get();

        $submission->load('mahasiswa');

        return view('dosen.submissions.review', compact('submission', 'comments'));
    }

    public function addComment(Request $request, SubmissionFile $submission): RedirectResponse
    {
        $this->authorize('addComment', $submission);

        // PERBAIKAN 8: Mengubah validasi status agar sesuai dengan isi ENUM database ('revisi')
        $validated = $request->validate([
            'comment' => 'required|string|max:5000',
            'status' => 'required|in:submitted,approved,revisi', // Sesuai ENUM DB asli
            'priority' => 'required|in:0,1,2',
            'is_pinned' => 'boolean',
        ]);

        $comment = Comment::create([
            'submission_id' => $submission->id,
            'dosen_id' => Auth::id(),
            'comment' => $validated['comment'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'is_pinned' => $validated['is_pinned'] ?? false,
        ]);

        $submission->update([
            'status' => $validated['status'],
            'dosen_id' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function approveSubmission(SubmissionFile $submission): RedirectResponse
    {
        $this->authorize('approve', $submission);

        $submission->update([
            'status' => 'approved',
            'dosen_id' => Auth::id(),
            'approved_at' => now(),
        ]);

        $bimbingan = $submission->bimbingan;

        $allApproved = $bimbingan->submissionFiles()
            ->where('status', '!=', 'approved')
            ->doesntExist();

        if ($allApproved) {
            $bimbingan->update(['status' => 'approved']);
        }

        // Update StatusMahasiswa berdasarkan fase bimbingan
        $fase = strtolower($bimbingan->fase ?? '');
        $mahasiswaId = $bimbingan->mahasiswa_id;

        $statusMahasiswa = \App\Models\StatusMahasiswa::firstOrCreate(
            ['mahasiswa_id' => $mahasiswaId],
            ['layak_sempro' => false, 'layak_sidang' => false]
        );

        if ($fase === 'sidang') {
            // Sidang disetujui -> set keduanya true
            $statusMahasiswa->update([
                'layak_sempro'         => true,
                'layak_sidang'         => true,
                'tanggal_layak_sempro' => $statusMahasiswa->tanggal_layak_sempro ?? now(),
                'tanggal_layak_sidang' => now(),
                'approved_by_dosen'    => Auth::id(),
            ]);
        } elseif (in_array($fase, ['proposal', 'sempro']) && !$statusMahasiswa->layak_sempro) {
            $statusMahasiswa->update([
                'layak_sempro'         => true,
                'tanggal_layak_sempro' => now(),
                'approved_by_dosen'    => Auth::id(),
            ]);
        }

        return back()->with('success', 'Submission berhasil disetujui');
    }

    public function rejectSubmission(Request $request, SubmissionFile $submission): RedirectResponse
    {
        $this->authorize('reject', $submission);

        $validated = $request->validate([
            'reason' => 'required|string|max:2000',
        ]);

        // Menyimpan status menjadi 'revisi' agar lolos validasi ENUM database
        $submission->update([
            'status' => 'revisi', 
            'dosen_id' => Auth::id(),
            'dosen_notes' => $validated['reason'],
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Submission berhasil ditolak / diminta revisi');
    }

    public function updateBimbinganStatus(Request $request, Bimbingan $bimbingan): RedirectResponse
    {
        $this->authorize('update', $bimbingan);

        $validated = $request->validate([
            'status' => 'required|in:pending,revisi,approved',
        ]);

        $bimbingan->update(['status' => $validated['status']]);

        return back()->with('success', 'Status bimbingan berhasil diperbarui');
    }

    public function history(): View
    {
        $dosenId = Auth::id();

        // PERBAIKAN 9: Perbaikan query pencarian riwayat bimbingan lewat sub-query mahasiswa_dosen
        $bimbingan = Bimbingan::whereIn('mahasiswa_id', function($query) use ($dosenId) {
                $query->select('mahasiswa_id')->from('mahasiswa_dosen')->where('dosen_id', $dosenId);
            })
            ->with(['mahasiswa', 'submissionFiles'])
            ->latest('created_at')
            ->paginate(20);

        return view('dosen.history', compact('bimbingan'));
    }
}