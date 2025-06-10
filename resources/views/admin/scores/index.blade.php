@extends('layouts.admin')
@section('title', 'Data Perhitungan (Skor)')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Input Nilai Instrumen</h1>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.scores.store') }}" method="POST">
        @csrf
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider sticky left-0 bg-gray-100 z-10">Instrumen</th>
                        @foreach ($criterias as $criteria)
                            <th colspan="{{ $criteria->subCriterias->count() }}" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-200 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ $criteria->name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider sticky left-0 bg-gray-100 z-10">Sub Kriteria -></th>
                         @foreach ($criterias as $criteria)
                            @foreach ($criteria->subCriterias as $subCriteria)
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ $subCriteria->name }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($instruments as $instrument)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-semibold sticky left-0 bg-white z-10">{{ $instrument->name }}</td>
                        @foreach ($criterias as $criteria)
                            @foreach ($criteria->subCriterias as $subCriteria)
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    @php
                                        $score_key = $instrument->id . '-' . $subCriteria->id;
                                        $existing_score = $scores->get($score_key);
                                    @endphp
                                    <input type="number" step="any" name="scores[{{ $instrument->id }}][{{ $subCriteria->id }}]" value="{{ $existing_score->score ?? '' }}" class="w-24 border-gray-300 rounded-md shadow-sm text-center">
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="100%" class="text-center py-4">Tidak ada data instrumen. Silakan tambah data instrumen terlebih dahulu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan Semua Skor</button>
        </div>
    </form>
</div>
@endsection