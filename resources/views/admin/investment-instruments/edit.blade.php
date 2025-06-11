@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Investment Instrument: {{ $investmentInstrument->name }}</h1>
    <a href="{{ route('admin.investment-instruments.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Back to List</a>

    <div class="bg-white shadow-md rounded-lg p-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.investment-instruments.update', $investmentInstrument->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Menggunakan metode PUT untuk update --}}

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Instrument Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $investmentInstrument->name) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Instrument Type (e.g., Berjangka, Saham):</label>
                <input type="text" name="type" id="type" value="{{ old('type', $investmentInstrument->type) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-6">Alternative Scores for Criteria:</h3>
            @forelse ($criterias as $criteria)
                <div class="mb-4">
                    <label for="criteria_scores_{{ $criteria->id }}" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ $criteria->name }} ({{ $criteria->code }}) Score:
                    </label>
                    @php
                        // Ambil skor yang sudah ada untuk kriteria ini, atau nilai default
                        $currentScoreValue = $currentScores[$criteria->id]->score ?? '';
                    @endphp
                    <input type="number" name="criteria_scores_{{ $criteria->id }}" id="criteria_scores_{{ $criteria->id }}" value="{{ old('criteria_scores_' . $criteria->id, $currentScoreValue) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-xs text-gray-500 mt-1">This is the Cout_i value for this instrument on this criteria.</p>
                </div>
            @empty
                <p class="text-gray-600">No criterias found. Please add criterias first.</p>
            @endforelse

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
                    Update Instrument
                </button>
            </div>
        </form>
    </div>
</div>
@endsection