<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\Models\StatusMahasiswa;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DosenBimbinganController extends Controller
{
    public function index()
    {
        $dosen = Auth::user();
        $mahasiswa = User::whereHas('bimbingans', function ($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id);
            })
            ->with('statusMahasiswa')
            ->get();

        return view('dosen.mahasiswa.index', compact('mahasiswa'));
    }

    public function showMahasiswa($id)
    {
        $dosen = Auth::user();
        $mahasiswa = User::where('id', $id)
            ->whereHas('bimbingans', function ($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id);
            })
            ->with('statusMahasiswa')
            ->firstOrFail();

        $bimbingan = Bimbingan::where('mahasiswa_id', $id)
            ->where('dosen_id', $dosen->id)
            ->latest()
            ->get();

        return view('dosen.mahasiswa.dosen lihat detail mahasiswa', compact('mahasiswa', 'bimbingan'));
    }

    // Memenuhi rute: dosen.bimbingan.review dan dosen.bimbingan.review-new
    public function reviewBimbingan($id)
    {
        $dosen = Auth::user();
        $bimbingan = Bimbingan::where('dosen_id', $dosen->id)
            ->with(['mahasiswa'])
            ->findOrFail($id);

        return view('dosen.Bimbingan.dosen review bimbingan', compact('bimbingan'));
    }

    // Memenuhi rute lama: dosen.bimbingan.submit-review
    public function submitReview(Request $request, $id)
    {
        $validated = $request->validate([
            'komentar'   => 'required|string',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'status'     => 'required|in:revisi,approved',
        ]);

        $dosen = Auth::user();
        $bimbingan = Bimbingan::where('dosen_id', $dosen->id)->findOrFail($id);

        DB::beginTransaction();
        try {
            $bimbingan->update([
                'komentar_dosen' => $validated['komentar'],
                'percentage'     => $validated['percentage'],
                'status'         => $validated['status'],
                'tanggal_revisi' => now(),
            ]);

            $submissionFile = DB::table('submission_files')
                ->where('bimbingan_id', $bimbingan->id)
                ->orderBy('id', 'desc')
                ->first();

            if ($submissionFile) {
                $subStatus = $validated['status'] == 'approved' ? 'approved' : 'reviewed';
                DB::table('submission_files')->where('id', $submissionFile->id)->update([
                    'status'      => $subStatus,
                    'dosen_notes' => $validated['komentar'],
                    'reviewed_at' => now(),
                    'approved_at' => $validated['status'] == 'approved' ? now() : null,
                ]);

                DB::table('comments')->insert([
                    'submission_id' => $submissionFile->id,
                    'dosen_id'      => $dosen->id,
                    'comment'       => $validated['komentar'],
                    'status'        => $validated['status'] == 'approved' ? 'approved' : 'revision_needed',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ]);
            }

            // Bug #6 Fix: Update status kelayakan mahasiswa berdasarkan fase bimbingan
            if ($validated['status'] === 'approved') {
                $statusMahasiswa = StatusMahasiswa::firstOrCreate(
                    ['mahasiswa_id' => $bimbingan->mahasiswa_id],
                    ['layak_sempro' => false, 'layak_sidang' => false]
                );

                $fase = strtolower($bimbingan->fase);

                if (in_array($fase, ['proposal', 'sempro']) && !$statusMahasiswa->layak_sempro) {
                    $statusMahasiswa->update([
                        'layak_sempro'         => true,
                        'tanggal_layak_sempro' => now(),
                        'approved_by_dosen'    => $dosen->id,
                    ]);
                } elseif ($fase === 'sidang' && $statusMahasiswa->layak_sempro && !$statusMahasiswa->layak_sidang) {
                    $statusMahasiswa->update([
                        'layak_sidang'         => true,
                        'tanggal_layak_sidang' => now(),
                        'approved_by_dosen'    => $dosen->id,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dosen.dashboard')->with('success', 'Review berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Memenuhi rute baru: dosen.bimbingan.comment-submission
    public function commentOnSubmission(Request $request, $submissionId)
    {
        $request->validate(['comment' => 'required|string']);
        $dosen = Auth::user();

        $submission = DB::table('submission_files')->where('id', $submissionId)->first();
        if (!$submission) { return back()->with('error', 'Berkas tidak ditemukan.'); }

        DB::table('comments')->insert([
            'submission_id' => $submissionId,
            'dosen_id'      => $dosen->id,
            'comment'       => $request->comment,
            'status'        => 'reviewed',
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    // Tombol Kelayakan Seminar / Sidang
    public function approveLayakSempro(Request $request, $mahasiswaId)
    {
        $dosen = Auth::user();
        $status = StatusMahasiswa::firstOrCreate(
            ['mahasiswa_id' => $mahasiswaId],
            ['layak_sempro' => false, 'layak_sidang' => false]
        );

        $status->update([
            'layak_sempro'         => true,
            'tanggal_layak_sempro' => now(),
            'approved_by_dosen'    => $dosen->id,
        ]);

        return back()->with('success', 'Mahasiswa dinyatakan layak sempro!');
    }

    public function approveLayakSidang(Request $request, $mahasiswaId)
    {
        $dosen = Auth::user();
        $status = StatusMahasiswa::where('mahasiswa_id', $mahasiswaId)->first();

        if (!$status || !$status->layak_sempro) {
            return back()->with('error', 'Mahasiswa harus layak sempro terlebih dahulu.');
        }

        $status->update([
            'layak_sidang'         => true,
            'tanggal_layak_sidang' => now(),
            'approved_by_dosen'    => $dosen->id,
        ]);

        return back()->with('success', 'Mahasiswa dinyatakan layak sidang!');
    }

    // Perjanjian Jadwal Temu (Appointments)
    public function appointmentRequests()
    {
        $pendingAppointments = Appointment::where('dosen_id', Auth::id())->where('status', 'pending')->with('mahasiswa')->get();
        $approvedAppointments = Appointment::where('dosen_id', Auth::id())->where('status', 'approved')->with('mahasiswa')->get();
        return view('dosen.Bimbingan.appointments', compact('pendingAppointments', 'approvedAppointments'));
    }

    public function mySchedule()
    {
        return redirect()->route('dosen.appointments.index');
    }

    public function approveAppointment($id)
    {
        Appointment::where('id', $id)->where('dosen_id', Auth::id())->update(['status' => 'approved', 'reason_for_rejection' => null]);
        return back()->with('success', 'Jadwal berhasil disetujui.');
    }

    public function rejectAppointment(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        Appointment::where('id', $id)->where('dosen_id', Auth::id())->update([
            'status'               => 'rejected',
            'reason_for_rejection' => $validated['reason'],
        ]);
        return back()->with('success', 'Jadwal berhasil ditolak.');
    }
}