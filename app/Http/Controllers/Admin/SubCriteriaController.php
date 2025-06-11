<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class SubCriteriaController extends Controller
{
    public function index()
    {
        $subCriterias = SubCriteria::with('criteria')->orderBy('criteria_id')->get();
        return view('admin.sub-criterias.index', compact('subCriterias'));
    }

    public function create()
    {
        $criterias = Criteria::all();
        return view('admin.sub-criterias.create', compact('criterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'criteria_id' => 'required|exists:criterias,id',
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0'
        ]);
        SubCriteria::create($request->all());
        return redirect()->route('admin.sub-criterias.index')->with('success', 'Sub Kriteria berhasil ditambahkan.');
    }

    public function edit(SubCriteria $subCriteria)
    {
        $criterias = Criteria::all();
        return view('admin.sub-criterias.edit', compact('subCriteria', 'criterias'));
    }

    public function update(Request $request, SubCriteria $subCriteria)
    {
        $request->validate([
            'criteria_id' => 'required|exists:criterias,id',
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0'
        ]);
        $subCriteria->update($request->all());
        return redirect()->route('admin.sub-criterias.index')->with('success', 'Sub Kriteria berhasil diperbarui.');
    }

    public function destroy(SubCriteria $subCriteria)
    {
        $subCriteria->delete();
        return redirect()->route('admin.sub-criterias.index')->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}