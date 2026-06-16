<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profile user
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        $statusMahasiswa = $user->isMahasiswa() ? $user->statusMahasiswa : null;

        return view('profile.show', [
            'user' => $user,
            'statusMahasiswa' => $statusMahasiswa
        ]);
    }

    /**
     * Menampilkan form edit profile
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.edit', [
            'user' => $user
        ]);
    }

    /**
     * Menyimpan perubahan profile
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'nim_nip' => 'nullable|string|max:20',
        ]);

        // Update user
        $user->update($validated);

        return redirect()->route('profile.show')
                       ->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Menampilkan form ubah password
     */
    public function editPassword()
    {
        return view('profile.change-password');
    }

    /**
     * Menyimpan perubahan password
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Handle Foto Profil upload
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Store the photo
            $path = $request->file('photo')->store('profile-photos', 'public');

            // Delete old photo if it exists
            if ($user->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }

            $user->update(['photo' => $path]);
        }

        // 2. Handle Password update (optional, only if fields are filled)
        if ($request->filled('current_password') || $request->filled('password')) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
