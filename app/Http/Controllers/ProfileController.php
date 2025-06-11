<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// ... (import model lain jika diperlukan)

class ProfileController extends Controller
{
    // ... (metode index dan showHistory yang sudah ada) ...

    // Tambahkan metode edit ini
    public function edit()
    {
        $user = Auth::user(); // Ambil user yang sedang login
        return view('profile.edit', compact('user')); // Tampilkan view dengan form edit
    }

    // Tambahkan metode update (untuk menangani POST/PUT dari form edit)
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // email harus unik kecuali untuk user itu sendiri
            // Tambahkan validasi lain seperti password jika ingin diubah
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = Hash::make($request->password); // Jika ingin ubah password
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
}