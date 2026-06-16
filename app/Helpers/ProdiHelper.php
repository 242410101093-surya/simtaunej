<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProdiHelper
{
    /**
     * Daftar NIM prefix per prodi
     */
    const PRODI_NIM_MAP = [
        'Sistem Informasi'    => '10101',
        'Teknologi Informasi' => '10102',
        'Informatika'         => '10103',
    ];

    /**
     * Dapatkan prodi dari admin yang sedang login.
     * Deteksi berdasarkan email atau prodi_asal.
     * Jika tidak dikenali (admin global), return null → berarti lihat semua.
     */
    public static function getAdminProdi(?User $user = null): ?string
    {
        $user = $user ?? Auth::user();
        if (!$user || $user->role !== 'admin') return null;

        // Cek dari kolom prodi_asal dulu
        if (!empty($user->prodi_asal)) {
            return $user->prodi_asal;
        }

        // Fallback: deteksi dari email
        $email = strtolower($user->email);
        if (str_contains($email, 'sisteminformasi')) {
            return 'Sistem Informasi';
        } elseif (str_contains($email, 'teknologiinformasi')) {
            return 'Teknologi Informasi';
        } elseif (str_contains($email, 'informatika')) {
            return 'Informatika';
        }

        // Admin global (tidak ada filter prodi)
        return null;
    }

    /**
     * Dapatkan prodi dari user mahasiswa.
     * Deteksi dari prodi_asal, lalu fallback dari NIM.
     */
    public static function getMahasiswaProdi(User $user): string
    {
        if (!empty($user->prodi_asal)) {
            return $user->prodi_asal;
        }

        $nim = $user->nim_nip ?? '';
        foreach (self::PRODI_NIM_MAP as $prodi => $prefix) {
            if (str_contains($nim, $prefix)) {
                return $prodi;
            }
        }

        return 'Informatika'; // default
    }

    /**
     * Dapatkan daftar ID mahasiswa yang sesuai prodi admin.
     * Jika prodi admin null (admin global), return null → berarti tidak filter.
     */
    public static function getMahasiswaIdsByAdminProdi(?string $adminProdi): ?array
    {
        if ($adminProdi === null) return null;

        $nimPrefix = self::PRODI_NIM_MAP[$adminProdi] ?? null;

        $query = User::where('role', 'mahasiswa');

        // Cari yang punya prodi_asal cocok, ATAU NIM mengandung prefix prodi
        $query->where(function ($q) use ($adminProdi, $nimPrefix) {
            $q->where('prodi_asal', $adminProdi);
            if ($nimPrefix) {
                $q->orWhere('nim_nip', 'like', '%' . $nimPrefix . '%');
            }
        });

        return $query->pluck('id')->toArray();
    }

    /**
     * Scope query mahasiswa berdasarkan prodi admin yang sedang login.
     */
    public static function scopeMahasiswaByAdminProdi($query, ?string $adminProdi = null): mixed
    {
        if ($adminProdi === null) return $query;

        $nimPrefix = self::PRODI_NIM_MAP[$adminProdi] ?? null;

        return $query->where(function ($q) use ($adminProdi, $nimPrefix) {
            $q->where('prodi_asal', $adminProdi);
            if ($nimPrefix) {
                $q->orWhere('nim_nip', 'like', '%' . $nimPrefix . '%');
            }
        });
    }
}
