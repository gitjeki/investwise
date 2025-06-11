<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalculationHistory; // Import model
use App\Models\Criteria; // Untuk mapping preferensi
use App\Models\SubCriteria; // Untuk mapping preferensi

class CalculationHistoryController extends Controller
{
    /**
     * Display a listing of the calculation histories for admin.
     * Menampilkan daftar semua riwayat perhitungan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua history perhitungan, beserta user yang terkait
        $histories = CalculationHistory::with('user')->latest()->get();

        // Ambil semua kriteria dan sub-kriteria untuk mapping ID ke nama/teks opsi
        $criterias = Criteria::all()->keyBy('id');
        $subCriterias = SubCriteria::all()->keyBy('id');

        return view('admin.calculation-histories.index', compact('histories', 'criterias', 'subCriterias'));
    }

    /**
     * Remove the specified calculation history from storage.
     * Menghapus riwayat perhitungan tertentu.
     *
     * @param  \App\Models\CalculationHistory  $calculationHistory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(CalculationHistory $calculationHistory)
    {
        $calculationHistory->delete();
        return redirect()->route('admin.calculation-histories.index')->with('success', 'Calculation history deleted successfully.');
    }
}