<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index()
    {
        return view('user.articles'); // Ubah dari 'articles' menjadi 'user.articles'
    }
}