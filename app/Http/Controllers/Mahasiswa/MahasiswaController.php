<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\StatusMahasiswa;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mahasiswaId = Auth::id();
        $user = Auth::user();

        $bimbingan = DB::table('bimbingans')
            ->where('mahasiswa_id', $mahasiswaId)
            ->orderBy('tanggal_upload', 'desc')
            ->get();

        $totalBimbingan    = $bimbingan->count();
        $bimbinganApproved = $bimbingan->where('status', 'approved')->count();

        // Ambil atau buat status dari tabel status_mahasiswa
        $statusModel = StatusMahasiswa::firstOrCreate(
            ['mahasiswa_id' => $mahasiswaId],
            ['layak_sempro' => false, 'layak_sidang' => false]
        );

        // === AUTO-SYNC: Sinkronisasi status berdasarkan data bimbingan approved ===
        // Ini memastikan data lama yang sudah diapprove dosen tetap terbaca di dashboard
        $approvedBimbingan = DB::table('bimbingans')
            ->where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'approved')
            ->get();

        $hasSidangApproved  = $approvedBimbingan->where('fase', 'sidang')->count() > 0;
        $hasSemproApproved  = $approvedBimbingan->whereIn('fase', ['sempro', 'proposal'])->count() > 0;

        if ($hasSidangApproved && (!$statusModel->layak_sempro || !$statusModel->layak_sidang)) {
            // Jika ada bimbingan sidang yang disetujui → layak sempro & sidang
            $statusModel->update([
                'layak_sempro'         => true,
                'layak_sidang'         => true,
                'tanggal_layak_sempro' => $statusModel->tanggal_layak_sempro ?? now(),
                'tanggal_layak_sidang' => $statusModel->tanggal_layak_sidang ?? now(),
            ]);
            $statusModel->refresh();
        } elseif ($hasSemproApproved && !$statusModel->layak_sempro) {
            // Jika ada bimbingan sempro/proposal yang disetujui → layak sempro
            $statusModel->update([
                'layak_sempro'         => true,
                'tanggal_layak_sempro' => $statusModel->tanggal_layak_sempro ?? now(),
            ]);
            $statusModel->refresh();
        }
        // === END AUTO-SYNC ===

        $dosenPembimbing = DB::table('bimbingans')
            ->join('users', 'bimbingans.dosen_id', '=', 'users.id')
            ->where('bimbingans.mahasiswa_id', $mahasiswaId)
            ->select('users.id', 'users.name', 'users.email')
            ->distinct()
            ->get();

        $riwayatBimbingan = DB::table('bimbingans')
            ->join('users', 'bimbingans.dosen_id', '=', 'users.id')
            ->where('bimbingans.mahasiswa_id', $mahasiswaId)
            ->select('bimbingans.*', 'users.name as dosen_name')
            ->orderBy('bimbingans.tanggal_upload', 'desc')
            ->get()
            ->map(function ($item) {
                $item->dosen = (object)['name' => $item->dosen_name];
                return $item;
            });

        $status = $statusModel;
        $dosens = \App\Models\User::where('role', 'dosen')->orderBy('name', 'asc')->get();

        // OPTIMALISASI: Mengambil jadwal bimbingan mendatang di controller
        $nowDate = \Carbon\Carbon::now()->toDateString();
        $nowTime = \Carbon\Carbon::now()->format('H:i:s');
        
        $upcomingAppointments = \App\Models\Appointment::where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'approved')
            ->where(function($query) use ($nowDate, $nowTime) {
                $query->where('scheduled_date', '>', $nowDate)
                      ->orWhere(function($q) use ($nowDate, $nowTime) {
                          $q->where('scheduled_date', '=', $nowDate)
                            ->where('scheduled_time', '>=', $nowTime);
                      });
            })
            ->with('dosen')
            ->orderBy('scheduled_date', 'asc')
            ->orderBy('scheduled_time', 'asc')
            ->take(5)
            ->get();

        return view('Mahasiswa.dashboard', compact(
            'bimbingan', 'status', 'user',
            'totalBimbingan', 'bimbinganApproved',
            'dosenPembimbing', 'riwayatBimbingan', 'dosens', 'upcomingAppointments'
        ));
    }

    public function bimbingan()
    {
        $mahasiswaId = Auth::id();

        $bimbingan = DB::table('bimbingans')
            ->where('mahasiswa_id', $mahasiswaId)
            ->orderBy('tanggal_upload', 'desc')
            ->get();

        $status = 'Aktif';

        return view('Mahasiswa.Bimbingan.index', compact('bimbingan', 'status'));
    }

    public function showBimbingan($id)
    {
        $bimbingan = Bimbingan::where('id', $id)
            ->where('mahasiswa_id', Auth::id())
            ->with(['dosen', 'submissionFiles'])
            ->firstOrFail();

        $status = $bimbingan->status;

        return view('Mahasiswa.Bimbingan.show', compact('bimbingan', 'status'));
    }

    public function progress()
    {
        $status = 'Progress';
        $bimbingan = Bimbingan::where('mahasiswa_id', Auth::id())
            ->orderBy('tanggal_upload', 'desc')
            ->get();

        return view('Mahasiswa.progress', compact('status', 'bimbingan'));
    }

    public function uploadForm($bimbingan)
    {
        $bimbinganModel = Bimbingan::where('id', $bimbingan)
            ->where('mahasiswa_id', Auth::id())
            ->firstOrFail();

        return view('Mahasiswa.Bimbingan.create', compact('bimbinganModel'));
    }

    public function storeUpload(Request $request, $bimbingan)
    {
        $request->validate([
            'file'      => 'required|file|mimes:pdf,doc,docx,odt|max:10240',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $bimbinganModel = Bimbingan::where('id', $bimbingan)
            ->where('mahasiswa_id', Auth::id())
            ->firstOrFail();

        $filePath = $request->file('file')->store('bimbingan', 'public');

        SubmissionFile::create([
            'bimbingan_id' => $bimbinganModel->id,
            'mahasiswa_id' => Auth::id(),
            'dosen_id'     => $bimbinganModel->dosen_id,
            'file_name'    => $request->judul,
            'description'  => $request->deskripsi,
            'file_path'    => $filePath,
            'file_type'    => 'draft',
            'file_size'    => $request->file('file')->getSize(),
            'status'       => 'submitted',
            'submitted_at' => now(),
        ]);

        $bimbinganModel->update([
            'judul'          => $request->judul,
            'status'         => 'pending',
            'tanggal_upload' => now(),
            'file_path'      => $filePath,
        ]);

        return redirect()->route('mahasiswa.bimbingan.show', $bimbingan)
            ->with('success', 'File berhasil diupload.');
    }

    public function showSubmission($submission)
    {
        $submissionModel = SubmissionFile::where('id', $submission)
            ->where('mahasiswa_id', Auth::id())
            ->with(['bimbingan.dosen'])
            ->firstOrFail();

        return view('Mahasiswa.submissions.show', ['submission' => $submissionModel]);
    }

    public function downloadArchive($bimbingan)
    {
        $bimbinganModel = Bimbingan::where('id', $bimbingan)
            ->where('mahasiswa_id', Auth::id())
            ->with('submissionFiles')
            ->firstOrFail();

        $files = $bimbinganModel->submissionFiles;

        if ($files->isEmpty()) {
            return back()->with('error', 'Tidak ada file untuk diunduh.');
        }

        $zipName = 'bimbingan_' . $bimbingan . '_archive.zip';
        $zipPath = storage_path('app/public/temp/' . $zipName);

        // Buat direktori temp jika belum ada
        if (!file_exists(storage_path('app/public/temp'))) {
            mkdir(storage_path('app/public/temp'), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Gagal membuat file arsip.');
        }

        foreach ($files as $file) {
            $filePath = storage_path('app/public/' . $file->file_path);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $file->file_name . '_' . $file->id . '.' . pathinfo($file->file_path, PATHINFO_EXTENSION));
            }
        }
        $zip->close();

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    public function viewFile($id)
    {
        $mahasiswaId = Auth::id();
        $bimbingan = Bimbingan::where('id', $id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->firstOrFail();

        if (!$bimbingan->file_path || !Storage::disk('public')->exists($bimbingan->file_path)) {
            abort(404, 'File bimbingan tidak ditemukan atau sudah dihapus.');
        }

        $isDownload = request()->has('download');
        
        if ($isDownload) {
            return Storage::disk('public')->download($bimbingan->file_path, 'Bimbingan_' . $bimbingan->judul . '.' . pathinfo($bimbingan->file_path, PATHINFO_EXTENSION));
        }

        return Storage::disk('public')->response($bimbingan->file_path);
    }

    public function viewSubmissionFile($id)
    {
        $mahasiswaId = Auth::id();
        $submission = SubmissionFile::where('id', $id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->firstOrFail();

        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            abort(404, 'File revisi tidak ditemukan atau sudah dihapus.');
        }

        $isDownload = request()->has('download');
        
        if ($isDownload) {
            return Storage::disk('public')->download($submission->file_path, $submission->file_name);
        }

        return Storage::disk('public')->response($submission->file_path);
    }
}
