<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article; // PASTIKAN ANDA MENG-IMPORT MODEL ARTICLE

class ArticlesController extends Controller
{
    /**
     * Menampilkan daftar artikel untuk user.
     */
    public function index()
    {
        // --- LANGKAH DEBUGGING ---
        // Kita sementara akan mengambil SEMUA artikel untuk melihat apakah ada data yang sampai ke view.
        // Baris query yang lama kita beri komentar untuk sementara.
        /*
        $articles = Article::whereNotNull('published_at')       // 1. Ambil hanya yang tanggal publish-nya tidak kosong
                           ->where('published_at', '<=', now()) // 2. Pastikan tanggal publish-nya adalah hari ini atau sebelumnya
                           ->latest('published_at')            // 3. Urutkan dari yang paling baru
                           ->get();                              // 4. Ambil datanya
        */

        $articles = Article::latest()->get(); // Ambil semua artikel, urutkan dari yang terbaru

        // Kirim data artikel dari database ke view
        return view('user.articles', compact('articles'));
    }
}
