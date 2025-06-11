<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\SubCriteria;

class CriteriaController extends Controller
{
    // Menampilkan daftar kriteria
    public function index()
    {
        $criterias = Criteria::all();
        return view('admin.criterias.index', compact('criterias'));
    }

    // Menampilkan form tambah kriteria
    public function create()
    {
        return view('admin.criterias.create');
    }

    // Menyimpan kriteria baru
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:criterias,code|max:255',
            'name' => 'required|max:255',
            'type' => 'required|in:benefit,cost',
            'question' => 'nullable|string',
        ]);

        Criteria::create($request->all());
        return redirect()->route('admin.criterias.index')->with('success', 'Criteria created successfully.');
    }

    // Menampilkan form edit kriteria
    public function edit(Criteria $criteria)
    {
        return view('admin.criterias.edit', compact('criteria'));
    }

    // Memperbarui kriteria
    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'code' => 'required|unique:criterias,code,'.$criteria->id.'|max:255',
            'name' => 'required|max:255',
            'type' => 'required|in:benefit,cost',
            'question' => 'nullable|string',
        ]);

        $criteria->update($request->all());
        return redirect()->route('admin.criterias.index')->with('success', 'Criteria updated successfully.');
    }

    // Menghapus kriteria
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('admin.criterias.index')->with('success', 'Criteria deleted successfully.');
    }

    // --- Metode untuk mengelola Sub-Kriteria ---

    public function manageSubCriterias(Criteria $criteria)
    {
        $subCriterias = $criteria->subCriterias()->get();
        return view('admin.criterias.subcriterias', compact('criteria', 'subCriterias'));
    }

    public function storeSubCriteria(Request $request, Criteria $criteria)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
            'weight' => 'required|integer|min:0|max:100', // Sesuaikan range bobot
        ]);

        $criteria->subCriterias()->create($request->all());
        return redirect()->route('admin.criterias.subcriterias.index', $criteria)->with('success', 'Sub-criteria added successfully.');
    }

    public function updateSubCriteria(Request $request, SubCriteria $subcriteria)
    {
        $request->validate([
            'option_text' => 'required|string|max:255',
            'weight' => 'required|integer|min:0|max:100',
        ]);

        $subcriteria->update($request->all());
        return redirect()->route('admin.criterias.subcriterias.index', $subcriteria->criteria)->with('success', 'Sub-criteria updated successfully.');
    }

    public function destroySubCriteria(SubCriteria $subcriteria)
    {
        $criteria = $subcriteria->criteria;
        $subcriteria->delete();
        return redirect()->route('admin.criterias.subcriterias.index', $criteria)->with('success', 'Sub-criteria deleted successfully.');
    }
}