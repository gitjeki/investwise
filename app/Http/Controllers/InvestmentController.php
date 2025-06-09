<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function show($type)
    {
        $allowedTypes = ['emas', 'deposito', 'obligasi', 'reksadana', 'trading'];

        if (!in_array($type, $allowedTypes)) {
            abort(404);
        }

        // Jika show.blade.php ada di resources/views/user/investment/
        return view('user.investment.show', compact('type')); // Sesuaikan jika Anda membuat subfolder 'investment'
        // ATAU
        // Jika show.blade.php ada langsung di resources/views/user/
        // return view('user.show', compact('type'));
    }
}