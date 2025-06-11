<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentInstrument; // Import model
use App\Models\Criteria; // Import model Criteria untuk skor alternatif
use App\Models\AlternativeScore; // Import model AlternativeScore

class InvestmentInstrumentController extends Controller
{
    /**
     * Display a listing of the investment instruments.
     * Menampilkan daftar semua instrumen investasi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $instruments = InvestmentInstrument::all();
        return view('admin.investment-instruments.index', compact('instruments'));
    }

    /**
     * Show the form for creating a new investment instrument.
     * Menampilkan form untuk membuat instrumen investasi baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $criterias = Criteria::all(); // Untuk menampilkan semua kriteria saat menambah skor
        return view('admin.investment-instruments.create', compact('criterias'));
    }

    /**
     * Store a newly created investment instrument in storage.
     * Menyimpan instrumen investasi baru ke database beserta skornya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            // Hapus aturan 'unique:investment_instruments,name'
            'name' => 'required|max:255',
            'type' => 'nullable|string|max:255',
            // Validasi skor kriteria (opsional, bisa ditambahkan sesuai kebutuhan)
        ]);

        $instrument = InvestmentInstrument::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        // LOGIKA PENYIMPANAN SKOR ALTERNATIF DITAMBAHKAN KEMBALI
        $criterias = Criteria::all();
        foreach ($criterias as $criteria) {
            $scoreFieldName = 'criteria_scores_' . $criteria->id;
            if ($request->has($scoreFieldName) && is_numeric($request->$scoreFieldName)) {
                AlternativeScore::create([
                    'instrument_id' => $instrument->id,
                    'criteria_id' => $criteria->id,
                    'score' => $request->$scoreFieldName,
                ]);
            }
        }

        return redirect()->route('admin.investment-instruments.index')->with('success', 'Investment instrument created successfully.');
    }

    /**
     * Display the specified investment instrument.
     * Menampilkan detail instrumen investasi tertentu (opsional).
     *
     * @param  \App\Models\InvestmentInstrument  $investmentInstrument
     * @return \Illuminate\View\View
     */
    public function show(InvestmentInstrument $investmentInstrument)
    {
        $scores = $investmentInstrument->alternativeScores->keyBy('criteria_id');
        $criterias = Criteria::all()->keyBy('id');
        return view('admin.investment-instruments.show', compact('investmentInstrument', 'scores', 'criterias'));
    }

    /**
     * Show the form for editing the specified investment instrument.
     * Menampilkan form untuk mengedit instrumen investasi tertentu.
     *
     * @param  \App\Models\InvestmentInstrument  $investmentInstrument
     * @return \Illuminate\View\View
     */
    public function edit(InvestmentInstrument $investmentInstrument)
    {
        $criterias = Criteria::all();
        // Ambil skor saat ini dan indeks berdasarkan criteria_id agar mudah diakses di view
        $currentScores = $investmentInstrument->alternativeScores->keyBy('criteria_id');
        return view('admin.investment-instruments.edit', compact('investmentInstrument', 'criterias', 'currentScores'));
    }

    /**
     * Update the specified investment instrument in storage.
     * Memperbarui instrumen investasi tertentu di database beserta skornya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvestmentInstrument  $investmentInstrument
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, InvestmentInstrument $investmentInstrument)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        $investmentInstrument->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        $criterias = Criteria::all();
        foreach ($criterias as $criteria) {
            $scoreFieldName = 'criteria_scores_' . $criteria->id;
            if ($request->has($scoreFieldName) && is_numeric($request->$scoreFieldName)) {
                AlternativeScore::updateOrCreate(
                    [
                        'instrument_id' => $investmentInstrument->id,
                        'criteria_id' => $criteria->id,
                    ],
                    [
                        'score' => $request->$scoreFieldName,
                    ]
                );
            } else {
                // Opsional: Jika skor tidak ada di request, hapus atau biarkan saja
                // AlternativeScore::where('instrument_id', $investmentInstrument->id)
                //                 ->where('criteria_id', $criteria->id)
                //                 ->delete();
            }
        }

        return redirect()->route('admin.investment-instruments.index')->with('success', 'Investment instrument updated successfully.');
    }

    /**
     * Remove the specified investment instrument from storage.
     * Menghapus instrumen investasi dari database.
     *
     * @param  \App\Models\InvestmentInstrument  $investmentInstrument
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(InvestmentInstrument $investmentInstrument)
    {
        $investmentInstrument->delete(); // Ini juga akan menghapus skor alternatif karena onDelete('cascade')
        return redirect()->route('admin.investment-instruments.index')->with('success', 'Investment instrument deleted successfully.');
    }
}