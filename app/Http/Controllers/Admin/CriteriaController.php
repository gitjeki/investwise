<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Criteria; // Import model Criteria
use App\Models\SubCriteria; // Import model SubCriteria
use Illuminate\Validation\Rule; // Untuk validasi unique kecuali diri sendiri

class CriteriaController extends Controller
{
    /**
     * Display a listing of the criteria.
     * Menampilkan daftar semua kriteria.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $criterias = Criteria::all(); // Ambil semua kriteria
        return view('admin.criterias.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new criteria.
     * Menampilkan form untuk membuat kriteria baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.criterias.create');
    }

    /**
     * Store a newly created criteria in storage.
     * Menyimpan kriteria baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => ['required', Rule::in(['benefit', 'cost'])],
            'question' => 'nullable|string',
        ]);
        $nextId = Criteria::max('id') + 1; // Mendapatkan ID potensial berikutnya
        $code = 'C' . $nextId;
        while(Criteria::where('code', $code)->exists()){
            $nextId++;
            $code = 'C' . $nextId;
        }

        $criteria = Criteria::create([
            'code' => $code, // Buat code otomatis
            'name' => $request->name,
            'type' => $request->type,
            'question' => $request->question,
        ]);
        return redirect()->route('admin.criterias.index')->with('success', 'Kriteria "' . $criteria->name . '" berhasil ditambahkan dengan kode: ' . $criteria->code . '.');
    
    }

    /**
     * Display the specified criteria.
     * Menampilkan detail kriteria tertentu (biasanya tidak digunakan untuk resource kriteria).
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\View\View
     */
    public function show(Criteria $criteria)
    {
        // Ini bisa digunakan untuk melihat detail kriteria atau langsung redirect ke manage sub-kriteria
        return redirect()->route('admin.criterias.subcriterias.index', $criteria);
    }

    /**
     * Show the form for editing the specified criteria.
     * Menampilkan form untuk mengedit kriteria tertentu.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\View\View
     */
    public function edit(Criteria $criteria)
    {
        return view('admin.criterias.edit', compact('criteria'));
    }

    /**
     * Update the specified criteria in storage.
     * Memperbarui kriteria tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'code' => ['required', Rule::unique('criterias')->ignore($criteria->id), 'max:255'], // Code unik kecuali untuk diri sendiri
            'name' => 'required|max:255',
            'type' => ['required', Rule::in(['benefit', 'cost'])],
            'question' => 'nullable|string',
        ]);

        $criteria->update($request->all()); // Perbarui kriteria
        return redirect()->route('admin.criterias.index')->with('success', 'Criteria updated successfully.');
    }

    /**
     * Remove the specified criteria from storage.
     * Menghapus kriteria dari database.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete(); // Hapus kriteria (akan menghapus sub-kriteria terkait juga karena onDelete('cascade'))
        return redirect()->route('admin.criterias.index')->with('success', 'Criteria deleted successfully.');
    }


    // --- Metode untuk Mengelola Sub-Kriteria ---

    /**
     * Display a listing of sub-criterias for a specific criteria.
     * Menampilkan daftar sub-kriteria untuk kriteria tertentu.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\View\View
     */
    public function manageSubCriterias(Criteria $criteria)
    {
        // Ambil semua sub-kriteria yang terkait dengan kriteria ini
        $subCriterias = $criteria->subCriterias()->get();
        return view('admin.criterias.subcriterias', compact('criteria', 'subCriterias'));
    }

    /**
     * Store a newly created sub-criteria for a specific criteria.
     * Menyimpan sub-kriteria baru untuk kriteria tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSubCriteria(Request $request, Criteria $criteria)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
            'weight' => 'required|integer|min:0|max:100', // Sesuaikan range bobot sesuai kebutuhan
        ]);

        $criteria->subCriterias()->create($request->all()); // Buat sub-kriteria baru dan kaitkan dengan kriteria
        return redirect()->route('admin.criterias.subcriterias.index', $criteria)->with('success', 'Sub-criteria added successfully.');
    }

    /**
     * Update the specified sub-criteria in storage.
     * Memperbarui sub-kriteria tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCriteria  $subcriteria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSubCriteria(Request $request, SubCriteria $subcriteria)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
            'weight' => 'required|integer|min:0|max:100',
        ]);

        $subcriteria->update($request->all()); // Perbarui sub-kriteria
        return redirect()->route('admin.criterias.subcriterias.index', $subcriteria->criteria)->with('success', 'Sub-criteria updated successfully.');
    }

    /**
     * Remove the specified sub-criteria from storage.
     * Menghapus sub-kriteria dari database.
     *
     * @param  \App\Models\SubCriteria  $subcriteria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroySubCriteria(SubCriteria $subcriteria)
    {
        $criteria = $subcriteria->criteria; // Simpan referensi ke kriteria induk
        $subcriteria->delete(); // Hapus sub-kriteria
        return redirect()->route('admin.criterias.subcriterias.index', $criteria)->with('success', 'Sub-criteria deleted successfully.');
    }
}