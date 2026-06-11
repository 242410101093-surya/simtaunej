<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Appointment;
use App\Models\StatusMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MahasiswaBimbinganController extends Controller
{
    public function create()
    {
        $dosens = User::where('role', 'dosen')->orderBy('name', 'asc')->get();
        return view('Mahasiswa.Bimbingan.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen_id'   => 'required|exists:users,id',
            'fase'       => 'required|string|in:proposal,sempro,sidang',
            'file'       => 'required|file|mimes:pdf,doc,docx,odt|max:10240',
            'judul'      => 'required|string',
            'deskripsi'  => 'nullable|string',
        ]);

        $filePath = $request->file('file')->store('bimbingan', 'public');
        $fileSize = $request->file('file')->getSize();
        $fileName = $request->file('file')->getClientOriginalName();

        $faseMap = ['proposal' => 'sempro', 'sempro' => 'sempro', 'sidang' => 'sidang'];
        $normalizedFase = $faseMap[strtolower($request->fase)] ?? 'sempro';

        DB::beginTransaction();
        try {
            $bimbingan = Bimbingan::create([
                'judul'          => $request->judul,
                'mahasiswa_id'   => Auth::id(),
                'dosen_id'       => $request->dosen_id,
                'fase'           => $normalizedFase,
                'file_path'      => $filePath,
                'deskripsi'      => $request->deskripsi,
                'status'         => 'pending',
                'tanggal_upload' => now(),
            ]);

            DB::table('submission_files')->insert([
                'bimbingan_id'  => $bimbingan->id,
                'mahasiswa_id'  => Auth::id(),
                'dosen_id'      => $request->dosen_id,
                'file_name'     => $fileName,
                'file_path'     => $filePath,
                'file_type'     => 'draft',
                'file_size'     => $fileSize,
                'description'   => $request->deskripsi,
                'status'        => 'submitted',
                'submitted_at'  => now(),
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            DB::commit();
            return redirect()->route('mahasiswa.dashboard')->with('success', 'Bimbingan berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function appointmentsIndex() {
        $dosens = User::where('role', 'dosen')->orderBy('name', 'asc')->get();
        return view('Mahasiswa.Bimbingan.appointments', compact('dosens'));
    }

    public function bookAppointment(Request $request)
    {
        $request->validate([
            'dosen_id'       => 'required|exists:users,id',
            'scheduled_date' => 'required|date|after:today',
            'scheduled_time' => 'required|date_format:H:i',
            'notes'          => 'nullable|string',
        ]);

        Appointment::create([
            'mahasiswa_id'   => Auth::id(),
            'dosen_id'       => $request->dosen_id,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes'          => $request->notes,
            'status'         => 'pending',
        ]);

        return redirect()->route('mahasiswa.appointments.my')->with('success', 'Booking jadwal berhasil diajukan.');
    }

    public function myAppointments()
    {
        $appointments = Appointment::where('mahasiswa_id', Auth::id())->with('dosen')->latest()->get();
        return view('Mahasiswa.Bimbingan.my-appointments', compact('appointments'));
    }

    public function exportHistory()
    {
        $mahasiswa = Auth::user();
        $bimbingan = Bimbingan::where('mahasiswa_id', $mahasiswa->id)->orderBy('tanggal_upload', 'asc')->get();
        $status = StatusMahasiswa::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('Mahasiswa.Bimbingan.riwayat bimbingan', compact('mahasiswa', 'bimbingan', 'status'));
    }

    public function cancelAppointment($id)
    {
        Appointment::where('id', $id)->where('mahasiswa_id', Auth::id())->where('status', 'pending')->update(['status' => 'cancelled']);
        return redirect()->route('mahasiswa.appointments.my')->with('success', 'Booking jadwal dibatalkan.');
    }

    // Legacy: Show bimbingan detail (compat route)
    public function show($id)
    {
        $bimbingan = Bimbingan::where('id', $id)
            ->where('mahasiswa_id', Auth::id())
            ->with(['dosen', 'submissionFiles'])
            ->firstOrFail();

        return view('Mahasiswa.Bimbingan.show', compact('bimbingan'));
    }

    // Legacy: Download file bimbingan (compat route)
    public function download($id)
    {
        $bimbingan = Bimbingan::where('id', $id)
            ->where('mahasiswa_id', Auth::id())
            ->firstOrFail();

        if (!$bimbingan->file_path || !file_exists(storage_path('app/public/' . $bimbingan->file_path))) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download(storage_path('app/public/' . $bimbingan->file_path));
    }
}