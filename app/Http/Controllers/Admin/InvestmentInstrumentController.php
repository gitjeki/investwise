<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentInstrument;
use Illuminate\Http\Request;

class InvestmentInstrumentController extends Controller
{
    public function index()
    {
        $instruments = InvestmentInstrument::all();
        return view('admin.investment-instruments.index', compact('instruments'));
    }

    public function create()
    {
        return view('admin.investment-instruments.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:investment_instruments,name']);
        InvestmentInstrument::create($request->all());
        return redirect()->route('admin.investment-instruments.index')->with('success', 'Instrumen berhasil ditambahkan.');
    }

    public function edit(InvestmentInstrument $investmentInstrument)
    {
        return view('admin.investment-instruments.edit', compact('investmentInstrument'));
    }

    public function update(Request $request, InvestmentInstrument $investmentInstrument)
    {
        $request->validate(['name' => 'required|string|max:255|unique:investment_instruments,name,' . $investmentInstrument->id]);
        $investmentInstrument->update($request->all());
        return redirect()->route('admin.investment-instruments.index')->with('success', 'Instrumen berhasil diperbarui.');
    }

    public function destroy(InvestmentInstrument $investmentInstrument)
    {
        $investmentInstrument->delete();
        return redirect()->route('admin.investment-instruments.index')->with('success', 'Instrumen berhasil dihapus.');
    }
}