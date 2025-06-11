<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CalculationHistory;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\InvestmentInstrument;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index'); // Atau view profile Anda yang ada
    }

    public function showHistory()
    {
        $histories = Auth::user()->calculationHistories()->latest()->get();
        $criterias = Criteria::all()->keyBy('id'); // Untuk mapping ID kriteria ke nama
        $subCriterias = SubCriteria::all()->keyBy('id'); // Untuk mapping ID sub-kriteria ke opsi

        return view('profile.history', compact('histories', 'criterias', 'subCriterias'));
    }
}