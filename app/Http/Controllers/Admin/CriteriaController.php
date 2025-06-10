<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::orderBy('id')->get();
        return view('admin.criterias.index', compact('criterias'));
    }

    public function create()
    {
        return view('admin.criterias.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'weight' => 'required|numeric|min:0']);
        Criteria::create($request->all());
        return redirect()->route('admin.criterias.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Criteria $criteria)
    {
        return view('admin.criterias.edit', compact('criteria'));
    }

    public function update(Request $request, Criteria $criteria)
    {
        $request->validate(['name' => 'required|string|max:255', 'weight' => 'required|numeric|min:0']);
        $criteria->update($request->all());
        return redirect()->route('admin.criterias.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('admin.criterias.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}