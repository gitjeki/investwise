<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentInstrument;
use App\Models\Criteria;
use App\Models\CalculationHistory;
use App\Models\User; // Tetap import User untuk $jumlahUser

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahInstrument = InvestmentInstrument::count();
        $jumlahKriteria = Criteria::count();
        $jumlahPerhitungan = CalculationHistory::count();
        $jumlahUser = User::where('role', 'user')->count();

        // --- BAGIAN INI DIHAPUS ---
        // $rekomendasiTeratas = [];
        // $latestHistory = CalculationHistory::latest()->first();
        // if ($latestHistory) {
        //     $rekomendasiTeratas = $latestHistory->calculated_rankings;
        // }
        // --- AKHIR BAGIAN DIHAPUS ---

        // Variabel $rekomendasiTeratas DIHAPUS dari compact()
        return view('admin.dashboard', compact('jumlahInstrument', 'jumlahKriteria', 'jumlahPerhitungan', 'jumlahUser'));
    }
}