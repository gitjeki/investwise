<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen artikel dengan tabel.
     */
    public function index()
    {
        $articles = Article::latest()->get(); // Mengambil semua artikel, yang terbaru di atas
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'body' => 'required|string',
            'image' => 'nullable|url', // Bisa URL atau nanti kita ubah ke file upload
            'published_at' => 'nullable|date',
        ]);

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title), // Membuat slug otomatis dari judul
            'category' => $request->category,
            'body' => $request->body,
            'image' => $request->image,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit artikel.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Memperbarui artikel di database.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'body' => 'required|string',
            'image' => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'body' => $request->body,
            'image' => $request->image,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus artikel dari database.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
