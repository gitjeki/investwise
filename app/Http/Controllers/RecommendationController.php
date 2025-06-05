<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\InvestmentInstrument;
use App\Models\AlternativeScore;
use Illuminate\Support\Collection; // Pastikan ini digunakan jika Anda pakai collect()

class RecommendationController extends Controller
{
    public function index()
    {
        // Ambil semua kriteria beserta sub-kriterianya untuk menampilkan pertanyaan
        $criterias = Criteria::with('subCriterias')->orderBy('code')->get();

        return view('user.recommendation', [
            'criterias' => $criterias,
        ]);
    }

    public function calculate(Request $request)
    {
        $criterias = Criteria::with('subCriterias')->orderBy('code')->get();
        $validationRules = [];
        foreach ($criterias as $criteria) {
            // Validasi bahwa setiap kriteria memiliki jawaban (ID sub-kriteria)
            $validationRules["C{$criteria->id}_answer"] = 'required|exists:sub_criterias,id';
        }

        $validatedData = $request->validate($validationRules);

        // 1. Dapatkan Bobot Preferensi User dari Jawaban Pertanyaan
        $userWeights = [];
        foreach ($criterias as $criteria) {
            $selectedSubCriteriaId = $validatedData["C{$criteria->id}_answer"];
            $subCriteria = SubCriteria::find($selectedSubCriteriaId);
            if ($subCriteria) {
                // Bobot preferensi user adalah 'weight' dari sub_criteria yang dipilih
                $userWeights[$criteria->code] = $subCriteria->weight;
            }
        }

        // 2. Menghitung Normalisasi Bobot Preferensi (N)
        $totalUserWeightSum = array_sum($userWeights);
        $normalizedWeights = [];
        // Pastikan $totalUserWeightSum tidak nol untuk menghindari division by zero
        if ($totalUserWeightSum === 0) {
            return back()->withErrors(['message' => 'Total bobot preferensi tidak boleh nol.']);
        }
        foreach ($userWeights as $criterionCode => $weight) {
            $normalizedWeights[$criterionCode] = $weight / $totalUserWeightSum;
        }

        // 3. Menentukan Nilai Parameter pada Setiap Kriteria untuk Setiap Alternatif
        // Ambil semua instrumen investasi beserta skor alternatifnya
        $investmentInstruments = InvestmentInstrument::with(['alternativeScores.criteria'])->get();

        // Kumpulkan semua skor alternatif per kriteria untuk menentukan Cmin dan Cmax
        // Ini adalah nilai Cout_i untuk setiap instrumen pada setiap kriteria
        $allScoresByCriterion = [];
        foreach ($investmentInstruments as $instrument) {
            foreach ($instrument->alternativeScores as $altScore) {
                $allScoresByCriterion[$altScore->criteria->code][] = $altScore->score;
            }
        }

        // Pastikan $allScoresByCriterion terisi untuk setiap kriteria yang digunakan
        foreach ($criterias as $criteria) {
            if (!isset($allScoresByCriterion[$criteria->code]) || empty($allScoresByCriterion[$criteria->code])) {
                 return back()->withErrors(['message' => "Data skor alternatif untuk kriteria {$criteria->name} ({$criteria->code}) tidak lengkap. Harap periksa seeder/database."]);
            }
        }


        // 4. Menghitung Nilai Utility ui(ai)
        $utilityValues = [];
        foreach ($investmentInstruments as $instrument) {
            $instrumentName = $instrument->name;
            $utilityValues[$instrumentName] = [];
            foreach ($criterias as $criteria) { // Iterasi melalui kriteria dari DB
                $altScore = $instrument->alternativeScores->where('criteria_id', $criteria->id)->first();
                $Cout = $altScore ? $altScore->score : 0;

                // Pastikan Cmin/Cmax ada dan tidak nol untuk menghindari error
                $Cmin = min($allScoresByCriterion[$criteria->code]);
                $Cmax = max($allScoresByCriterion[$criteria->code]);

                if ($Cmax == $Cmin) { // Handle division by zero if all scores for a criteria are the same
                    $utility = 1;
                } elseif ($criteria->type === 'benefit') { // Benefit: semakin besar semakin baik
                    $utility = ($Cout - $Cmin) / ($Cmax - $Cmin);
                } else { // Cost: semakin kecil semakin baik
                    $utility = ($Cmax - $Cout) / ($Cmax - $Cmin);
                }
                $utilityValues[$instrumentName][$criteria->code] = $utility;
            }
        }

        // 5. Menghitung Nilai Hasil (Hasil = ui(ai) x N)
        $finalScores = [];
        $calculationSteps = [];

        foreach ($utilityValues as $instrumentName => $utilities) {
            $sumOfWeightedUtilities = 0;
            $calculationSteps[$instrumentName]['utilities'] = $utilities;
            $calculationSteps[$instrumentName]['weighted_results'] = [];

            foreach ($utilities as $criterionCode => $utility) {
                // Pastikan criterionCode dari utilities sesuai dengan normalizedWeights
                if (isset($normalizedWeights[$criterionCode])) {
                    $weightedResult = $utility * $normalizedWeights[$criterionCode];
                    $sumOfWeightedUtilities += $weightedResult;
                    $calculationSteps[$instrumentName]['weighted_results'][$criterionCode] = $weightedResult;
                } else {
                    // Ini bisa terjadi jika ada kriteria di $utilityValues tapi tidak di $normalizedWeights
                    // (harusnya tidak terjadi jika $criterias di awal konsisten)
                    $this->warn("Warning: Normalized weight for {$criterionCode} not found.");
                }
            }
            // 6. Penjumlahan Nilai Hasil Akhir (SMART = ΣHasil)
            $finalScores[$instrumentName] = $sumOfWeightedUtilities;
            $calculationSteps[$instrumentName]['final_score'] = $sumOfWeightedUtilities;
        }

        // 7. Perankingan Metode SMART
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
                'type' => InvestmentInstrument::where('name', $instrumentName)->first()->type ?? 'N/A' // Get type from DB
            ];
            $prevScore = $score;
        }

        return view('user.recommendation', [
            'criterias' => $criterias,
            'userSelectedOptions' => $validatedData,
            'userWeights' => $userWeights,
            'normalizedWeights' => $normalizedWeights,
            'utilityValues' => $utilityValues,
            'calculationSteps' => $calculationSteps,
            'finalScores' => $finalScores,
            'rankedRecommendations' => $rankedRecommendations,
            'investmentInstruments' => $investmentInstruments,
        ]);
    }
}