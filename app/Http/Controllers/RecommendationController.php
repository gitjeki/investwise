<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\InvestmentInstrument;
use App\Models\AlternativeScore;
use App\Models\CalculationHistory;
use Illuminate\Support\Collection;

class RecommendationController extends Controller
{
    // Halaman pengantar rekomendasi
    public function intro()
    {
        $criterias = Criteria::with('subCriterias')->orderBy('code')->get();
        return view('user.recommendation', ['criterias' => $criterias]);
    }

    // Menampilkan pertanyaan satu per satu untuk preferensi user
    public function showQuestion($step = 1)
    {
        $criterias = Criteria::with('subCriterias')->orderBy('code')->get();
        $totalSteps = $criterias->count();

        // Validasi langkah
        if ($step < 1 || $step > $totalSteps) {
            return redirect()->route('user.recommendation.intro');
        }

        $currentCriteria = $criterias->get($step - 1); // Ambil kriteria saat ini berdasarkan step

        // Pastikan session untuk preferensi ada
        if (!Session::has('user_preferences')) {
            Session::put('user_preferences', []);
        }

        return view('user.recommendation.questions', [
            'currentCriteria' => $currentCriteria,
            'step' => $step,
            'totalSteps' => $totalSteps,
            'userPreferences' => Session::get('user_preferences', []),
        ]);
    }

    // Menyimpan jawaban pertanyaan dan pindah ke pertanyaan berikutnya atau trigger perhitungan
    public function submitQuestion(Request $request)
    {
        $criterias = Criteria::orderBy('code')->get();
        $totalSteps = $criterias->count();

        $validated = $request->validate([
            'criteria_id' => 'required|exists:criterias,id',
            'selected_option_id' => 'required|exists:sub_criterias,id',
            'current_step' => 'required|integer|min:1|max:' . $totalSteps,
        ]);

        $criteriaId = $validated['criteria_id'];
        $selectedOptionId = $validated['selected_option_id'];
        $currentStep = $validated['current_step'];

        $userPreferences = Session::get('user_preferences', []);
        $userPreferences[$criteriaId] = $selectedOptionId;
        Session::put('user_preferences', $userPreferences);

        $nextStep = $currentStep + 1;

        if ($nextStep > $totalSteps) {
            return $this->calculateAndShowResults($request); 
        } else {
            return redirect()->route('user.recommendation.questions', ['step' => $nextStep]);
        }
    }

    // Metode untuk menghitung rekomendasi dan menampilkan hasil
    public function calculateAndShowResults(Request $request)
    {
        
        $userSelectedOptions = Session::get('user_preferences');

        $allCriterias = Criteria::all();
        if (empty($userSelectedOptions) || count($userSelectedOptions) !== $allCriterias->count()) {
            Session::forget('user_preferences');
            return redirect()->route('user.recommendation.questions', ['step' => 1])
                            ->withErrors(['message' => 'Harap jawab semua pertanyaan preferensi Anda untuk mendapatkan rekomendasi.']);
        }

        $criterias = Criteria::with('subCriterias')->orderBy('code')->get();

        $userWeights = [];
        foreach ($criterias as $criteria) {
            $selectedSubCriteriaId = $userSelectedOptions[$criteria->id] ?? null;
            $subCriteria = SubCriteria::find($selectedSubCriteriaId);
            if ($subCriteria) {
                $userWeights[$criteria->code] = $subCriteria->weight;
            } else {
                Session::forget('user_preferences');
                return redirect()->route('user.recommendation.questions', ['step' => 1])
                                ->withErrors(['message' => 'Pilihan preferensi tidak valid. Harap mulai ulang kuesioner.']);
            }
        }

        $totalUserWeightSum = array_sum($userWeights);
        if ($totalUserWeightSum === 0) {
            Session::forget('user_preferences');
            return redirect()->route('user.recommendation.questions', ['step' => 1])
                            ->withErrors(['message' => 'Total bobot preferensi tidak boleh nol. Harap mulai ulang kuesioner.']);
        }
        $normalizedWeights = [];
        foreach ($userWeights as $criterionCode => $weight) {
            $normalizedWeights[$criterionCode] = $weight / $totalUserWeightSum;
        }

        $investmentInstruments = InvestmentInstrument::with(['alternativeScores.criteria'])->get();

        $allScoresByCriterion = [];
        foreach ($investmentInstruments as $instrument) {
            foreach ($instrument->alternativeScores as $altScore) {
                if ($altScore->criteria) {
                    $allScoresByCriterion[$altScore->criteria->code][] = $altScore->score;
                }
            }
        }

        foreach ($criterias as $criteria) {
            if (!isset($allScoresByCriterion[$criteria->code]) || empty($allScoresByCriterion[$criteria->code])) {
                Session::forget('user_preferences');
                return redirect()->route('user.recommendation.questions', ['step' => 1])
                                ->withErrors(['message' => "Data skor alternatif untuk kriteria '{$criteria->name}' tidak lengkap. Harap hubungi administrator."]);
            }
        }

        $utilityValues = [];
        foreach ($investmentInstruments as $instrument) {
            $instrumentName = $instrument->name;
            $utilityValues[$instrumentName] = [];
            foreach ($criterias as $criteria) {
                $altScore = $instrument->alternativeScores->where('criteria_id', $criteria->id)->first();
                $Cout = $altScore ? $altScore->score : 0;

                $Cmin = min($allScoresByCriterion[$criteria->code]);
                $Cmax = max($allScoresByCriterion[$criteria->code]);

                if ($Cmax == $Cmin) {
                    $utility = 1;
                } elseif ($criteria->type === 'benefit') {
                    $utility = ($Cout - $Cmin) / ($Cmax - $Cmin);
                } else {
                    $utility = ($Cmax - $Cout) / ($Cmax - $Cmin);
                }
                $utilityValues[$instrumentName][$criteria->code] = $utility;
            }
        }

        $finalScores = [];
        $calculationSteps = [];

        foreach ($utilityValues as $instrumentName => $utilities) {
            $sumOfWeightedUtilities = 0;
            $calculationSteps[$instrumentName]['utilities'] = $utilities;
            $calculationSteps[$instrumentName]['weighted_results'] = [];

            foreach ($utilities as $criterionCode => $utility) {
                if (isset($normalizedWeights[$criterionCode])) {
                    $weightedResult = $utility * $normalizedWeights[$criterionCode];
                    $sumOfWeightedUtilities += $weightedResult;
                    $calculationSteps[$instrumentName]['weighted_results'][$criterionCode] = $weightedResult;
                }
            }
            $finalScores[$instrumentName] = $sumOfWeightedUtilities;
            $calculationSteps[$instrumentName]['final_score'] = $sumOfWeightedUtilities;
        }

        arsort($finalScores);
        $rankedRecommendations = [];
        $rank = 1;
        $prevScore = null;
        foreach ($finalScores as $instrumentName => $score) {
            if ($prevScore !== null && $score < $prevScore) {
                $rank++;
            }
            $rankedRecommendations[$instrumentName] = [
                'score' => $score,
                'rank' => $rank,
                'type' => InvestmentInstrument::where('name', $instrumentName)->first()->type ?? 'N/A'
            ];
            $prevScore = $score;
        }

        if (Auth::check()) {
            CalculationHistory::create([
                'user_id' => Auth::id(),
                'user_preferences' => $userSelectedOptions,
                'calculated_rankings' => array_slice($rankedRecommendations, 0, 5, true),
            ]);
        }

        Session::forget('user_preferences');

        return view('user.recommendation.results', [
            'criterias' => $criterias,
            'userSelectedOptions' => $userSelectedOptions,
            'userWeights' => $userWeights,
            'normalizedWeights' => $normalizedWeights,
            'utilityValues' => $utilityValues,
            'calculationSteps' => $calculationSteps,
            'finalScores' => $finalScores,
            'rankedRecommendations' => $rankedRecommendations,
            'top5Recommendations' => array_slice($rankedRecommendations, 0, 5, true),
            'investmentInstruments' => $investmentInstruments,
        ]);
    }

    // Metode untuk menampilkan hasil jika diakses langsung (misal dari history atau setelah perhitungan)
    public function showResults()
    {
        return redirect()->route('user.recommendation.intro')->withErrors(['message' => 'Akses langsung halaman hasil tidak diizinkan tanpa perhitungan. Harap mulai perhitungan terlebih dahulu.']);
    }
}