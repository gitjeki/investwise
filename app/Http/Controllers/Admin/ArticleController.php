<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str; // HAPUS INI JIKA TIDAK ADA LAGI USE LAIN UNTUK STR
// use Illuminate\Validation\Rule; // HAPUS INI JIKA TIDAK ADA LAGI USE LAIN UNTUK RULE

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        // HAPUS LOGIKA SLUG DI SINI
        /*
        $slug = Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        */

        Article::create([
            'title' => $validatedData['title'],
            'category' => $validatedData['category'],
            'body' => $validatedData['body'],
            'image_path' => $imagePath,
            'published_at' => $validatedData['published_at'],
            // 'slug' => $slug, // HAPUS INI
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $imagePath = $article->image_path;
        if ($request->hasFile('image')) {
            if ($article->image_path && !filter_var($article->image_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($article->image_path);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        // HAPUS LOGIKA SLUG DI SINI
        /*
        $slug = Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        */

        $article->update([
            'title' => $validatedData['title'],
            'category' => $validatedData['category'],
            'body' => $validatedData['body'],
            'image_path' => $imagePath,
            'published_at' => $validatedData['published_at'],
            // 'slug' => $slug, // HAPUS INI
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        if ($article->image_path && !filter_var($article->image_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($article->image_path);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}