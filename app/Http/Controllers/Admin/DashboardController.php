<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentInstrument;
use App\Models\Criteria;
use App\Models\CalculationHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahInstrument = InvestmentInstrument::count();
        $jumlahKriteria = Criteria::count();
        $jumlahPerhitungan = CalculationHistory::count();

        // Ambil 5 rekomendasi teratas dari perhitungan TERBARU
        // Ini akan mengambil array 'calculated_rankings' dari history terbaru
        $rekomendasiTeratas = [];
        $latestHistory = CalculationHistory::latest()->first(); // Ambil history perhitungan terbaru
        if ($latestHistory) {
            // calculated_rankings adalah JSON yang berisi top 5, jadi bisa langsung dipakai
            $rekomendasiTeratas = $latestHistory->calculated_rankings;
        }
        // Jika ingin menampilkan semua rekomendasi top 5 dari semua history, ini akan lebih kompleks

        return view('admin.dashboard', compact('jumlahInstrument', 'jumlahKriteria', 'jumlahPerhitungan', 'rekomendasiTeratas'));
    }
}