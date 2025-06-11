@extends('user.app')

@section('content')
<div class="container mx-auto px-4 py-8 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white rounded-2xl p-8 md:p-10 shadow-xl text-center w-full max-w-2xl border border-gray-100 transform hover:scale-105 transition-transform duration-300 ease-in-out">
        
        {{-- Pesan Error Validasi (Tailwind) --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada masalah dengan input Anda.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Jawab Pertanyaan untuk Menentukan Preferensi Anda</h3>
        <p class="text-center text-gray-500 text-sm mb-6">Step {{ $step }} of {{ $totalSteps }}</p>
        
        {{-- Progress Bar (Tailwind) --}}
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
            <div class="bg-green-600 h-2.5 rounded-full transition-all duration-500 ease-in-out" style="width: {{ ($step / $totalSteps) * 100 }}%"></div>
        </div>

        {{-- FORM UTAMA UNTUK PERTANYAAN --}}
        <form action="{{ route('user.recommendation.submit_question') }}" method="POST">
            @csrf
            <input type="hidden" name="criteria_id" value="{{ $currentCriteria->id }}">
            <input type="hidden" name="current_step" value="{{ $step }}">

            <div class="mb-8 text-left"> {{-- mb-8 untuk jarak antara pertanyaan --}}
                <label for="selected_option_id" class="block text-lg font-semibold text-gray-700 mb-3">
                    {{-- Menggunakan strong untuk bold, menghindari ** di Blade yang kadang diinterpretasikan Markdown --}}
                    <strong>{{ $currentCriteria->code }}:</strong> {{ $currentCriteria->question }}
                </label>
                <select class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-base text-gray-900" id="selected_option_id" name="selected_option_id" required>
                    <option value="">Pilih Jawaban Anda</option>
                    @foreach($currentCriteria->subCriterias as $subCriteria)
                        <option value="{{ $subCriteria->id }}"
                            {{ (isset($userPreferences[$currentCriteria->id]) && $userPreferences[$currentCriteria->id] == $subCriteria->id) ? 'selected' : '' }}>
                            {{ $subCriteria->option_text }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center mt-10"> {{-- mt-10 untuk jarak dari pertanyaan --}}
                {{-- Tombol Back --}}
                @if ($step > 1)
                    <a href="{{ route('user.recommendation.questions', ['step' => $step - 1]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out">
                        Back
                    </a>
                @else
                    <a href="{{ route('user.recommendation.intro') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out">
                        Back to Intro
                    </a>
                @endif

                {{-- Tombol Next / See Results --}}
                @if ($step < $totalSteps)
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                        Next
                    </button>
                @else
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                        See Results
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection