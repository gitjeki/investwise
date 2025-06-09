<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecommendationsController extends Controller
{
    public function index()
    {
        return view('user.recommendations'); // Ubah dari 'recommendations' menjadi 'user.recommendations'
    }
}