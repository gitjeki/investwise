<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentInstrument;
use App\Models\Criteria;
use App\Models\AlternativeScore;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahInstrument = InvestmentInstrument::count();
        $jumlahKriteria = Criteria::count();
        $jumlahPerhitungan = AlternativeScore::count();
        $rekomendasiTeratas = "Emas"; // Placeholder

        return view('admin.dashboard', compact('jumlahInstrument', 'jumlahKriteria', 'jumlahPerhitungan', 'rekomendasiTeratas'));
    }
}