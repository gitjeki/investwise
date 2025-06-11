@extends('user.app')

@section('content')
<div class="container mx-auto px-4 py-8 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white rounded-2xl p-8 md:p-10 shadow-xl text-center w-full max-w-2xl border border-gray-100">
        
        {{-- Pesan Error Validasi (Tailwind) --}}
        @if ($errors->any())
            <div id="error-message-box" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada masalah dengan input Anda.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <div id="error-message-box" class="hidden"></div> {{-- Placeholder jika tidak ada error --}}
        @endif

        <p class="text-xl md:text-2xl font-bold text-gray-900 mb-4">
            {{ $currentCriteria->question }}
        </p>
        
        <p class="text-center text-gray-500 text-sm mb-4">Step {{ $step }} of {{ $totalSteps }}</p>
        
        {{-- Progress Bar (Tailwind) --}}
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
            <div class="bg-green-600 h-2.5 rounded-full transition-all duration-500 ease-in-out" style="width: {{ ($step / $totalSteps) * 100 }}%"></div>
        </div>

        {{-- FORM UTAMA UNTUK PERTANYAAN --}}
        {{-- Action sekarang selalu ke submit_question --}}
        <form id="questionForm" action="{{ route('user.recommendation.submit_question') }}" method="POST">
            @csrf
            <input type="hidden" name="criteria_id" value="{{ $currentCriteria->id }}">
            <input type="hidden" name="current_step" value="{{ $step }}">
            <input type="hidden" name="selected_option_id" id="hidden_selected_option_id" required>

            <div class="mb-8 text-center">
                {{-- Opsi Jawaban sebagai Kartu --}}
                <div class="grid grid-cols-1 gap-4">
                    @foreach($currentCriteria->subCriterias as $subCriteria)
                    <div class="answer-card group cursor-pointer bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-200 ease-in-out" 
                         data-option-id="{{ $subCriteria->id }}"> {{-- data-criteria-id dan data-current-step tidak perlu di sini lagi --}}
                        <p class="text-base md:text-lg font-medium text-gray-700 group-hover:text-green-700">{{ $subCriteria->option_text }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between items-center mt-10">
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

                {{-- Tombol Next / See Results - Kembali menjadi type="submit" --}}
                <button type="submit" id="nextButton" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                    {{ ($step < $totalSteps) ? 'Next' : 'See Results' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const answerCards = document.querySelectorAll('.answer-card');
        const hiddenInput = document.getElementById('hidden_selected_option_id');
        const nextButton = document.getElementById('nextButton');
        const errorMessageDiv = document.getElementById('error-message-box');

        // Fungsi untuk menandai kartu yang dipilih dan menyimpan ID
        function selectCard(card) {
            answerCards.forEach(ac => {
                ac.classList.remove('bg-green-100', 'border-green-500', 'shadow-md', 'scale-105');
                ac.classList.add('bg-gray-50', 'border-gray-200', 'shadow-sm');
                ac.querySelector('p').classList.remove('text-green-800');
                ac.querySelector('p').classList.add('text-gray-700');
            });

            card.classList.add('bg-green-100', 'border-green-500', 'shadow-md', 'scale-105');
            card.classList.remove('bg-gray-50', 'border-gray-200', 'shadow-sm');
            card.querySelector('p').classList.add('text-green-800');
            card.querySelector('p').classList.remove('text-gray-700');
            
            hiddenInput.value = card.dataset.optionId; // Simpan ID pilihan ke hidden input
            nextButton.disabled = false; // Aktifkan tombol
            nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
            errorMessageDiv.classList.add('hidden'); // Sembunyikan error jika sudah pilih
        }

        // Tambahkan event listener ke setiap kartu jawaban
        answerCards.forEach(card => {
            card.addEventListener('click', function() {
                selectCard(this);
            });
        });

        // Setel pilihan default jika ada dari userPreferences (saat kembali ke pertanyaan sebelumnya)
        const userPreferences = @json($userPreferences);
        const currentCriteriaId = "{{ $currentCriteria->id }}";
        const selectedOptionFromSession = userPreferences[currentCriteriaId];

        if (selectedOptionFromSession) {
            const preSelectedCard = document.querySelector(`.answer-card[data-option-id="${selectedOptionFromSession}"]`);
            if (preSelectedCard) {
                selectCard(preSelectedCard);
            }
        } else {
            nextButton.disabled = true;
            nextButton.classList.add('opacity-50', 'cursor-not-allowed');
        }

        // Event listener submit form untuk menampilkan error jika belum ada pilihan
        document.getElementById('questionForm').addEventListener('submit', function(e) {
            if (!hiddenInput.value) {
                e.preventDefault(); // Mencegah submit
                errorMessageDiv.innerHTML = '<strong class="font-bold">Peringatan!</strong> <span class="block sm:inline">Harap pilih salah satu opsi sebelum melanjutkan.</span>';
                errorMessageDiv.classList.remove('hidden');
                errorMessageDiv.classList.add('bg-yellow-100', 'border-yellow-400', 'text-yellow-700'); // Styling untuk warning
            }
        });
    });
</script>
@endsection