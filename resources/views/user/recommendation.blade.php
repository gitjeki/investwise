@extends('user.app')

@section('content')
<div class="container mx-auto px-4 py-12 min-h-screen flex flex-col items-center justify-center">

    {{-- Call to Action Card --}}
    {{-- Tambahkan kelas -translate-y-XX untuk menggeser kartu ke atas --}}
    <div class="bg-white rounded-2xl p-10 md:p-12 shadow-xl text-center w-full max-w-2xl border border-gray-100 transform hover:scale-105 transition-transform duration-300 ease-in-out -translate-y-12">
        <h3 class="text-3xl md:text-4xl font-bold text-green-700 mb-6 leading-snug">
            Calculate Your Ideal Investment with <span class="text-green-500">SMART</span> Method
        </h3>
        <p class="text-lg md:text-xl text-gray-600 mb-10 leading-relaxed">
            Choose your priorities, set your goals, and get ranked investment recommendations based on real criteria.
        </p>
        <a href="{{ route('user.recommendation.questions', ['step' => 1]) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-10 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105 tracking-wide text-lg">
            Start Calculation
        </a>
    </div>

</div>

{{-- Custom CSS for floating animation (jika masih ada dan tidak dihapus, biarkan saja) --}}
@push('styles')
<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endpush

@endsection