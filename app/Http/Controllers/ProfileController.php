<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Criteria; 
use App\Models\SubCriteria;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user.
     */
    public function index()
    {
        // Mengambil data user yang sedang terautentikasi
        $user = Auth::user();
        
        // Mengirim data user ke view 'user.profile'
        return view('user.profile', compact('user'));
    }

    /**
     * Memperbarui informasi profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('status', 'profile-updated');
    }

    public function edit()
    {
        return view('user.profile_edit', [
            'user' => Auth::user(),
        ]);
    }


    /**
     * Memperbarui password user.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }


    public function showHistory()
    {
        // Ambil semua history perhitungan untuk user yang sedang login, diurutkan dari yang terbaru
        $histories = Auth::user()->calculationHistories()->latest()->get();

        // Ambil semua kriteria dan sub-kriteria untuk mapping ID ke nama/teks opsi
        // Ini penting karena user_preferences menyimpan ID, bukan nama/teks
        $criterias = Criteria::all()->keyBy('id'); // Mengindeks Collection berdasarkan ID kriteria
        $subCriterias = SubCriteria::all()->keyBy('id'); // Mengindeks Collection berdasarkan ID sub-kriteria

        return view('profile.history', compact('histories', 'criterias', 'subCriterias'));
    }
}