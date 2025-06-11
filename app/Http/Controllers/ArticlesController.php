<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticlesController extends Controller
{

    public function index()
    {
        $articles = Article::whereNotNull('published_at')
        ->where('published_at', '<=', now()) 
        ->latest()
        ->get();

        return view('user.articles', compact('articles'));  
    }
}
