<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlternativeScore;
use App\Models\Criteria;
use App\Models\InvestmentInstrument;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        $instruments = InvestmentInstrument::all();
        $criterias = Criteria::with('subCriterias')->get();
        $scores = AlternativeScore::all()->keyBy(fn($item) => $item->investment_instrument_id . '-' . $item->sub_criteria_id);
        return view('admin.scores.index', compact('instruments', 'criterias', 'scores'));
    }

    public function store(Request $request)
    {
        $request->validate(['scores' => 'required|array']);
        foreach ($request->scores as $instrument_id => $sub_criteria_scores) {
            foreach ($sub_criteria_scores as $sub_criteria_id => $score_value) {
                if (!is_null($score_value)) {
                    AlternativeScore::updateOrCreate(
                        ['investment_instrument_id' => $instrument_id, 'sub_criteria_id' => $sub_criteria_id],
                        ['score' => $score_value]
                    );
                }
            }
        }
        return redirect()->route('admin.scores.index')->with('success', 'Skor berhasil disimpan.');
    }
}