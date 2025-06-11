@extends('user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl p-8 md:p-10 shadow-xl w-full max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Hasil Rekomendasi Investasi</h1>
        <p class="text-center text-gray-600 mb-8">Berikut adalah peringkat instrumen investasi yang paling sesuai dengan preferensi Anda.</p>

        @if(isset($rankedRecommendations) && !empty($rankedRecommendations))
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instrumen Investasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor Akhir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($rankedRecommendations as $instrumentName => $details)
                            <tr class="{{ $loop->first ? 'bg-green-100' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-lg font-bold">{{ $details['rank'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $instrumentName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($details['score'], 4) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $details['type'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-10">
                <p class="text-gray-500">Maaf, tidak ada rekomendasi yang bisa ditampilkan berdasarkan pilihan Anda.</p>
            </div>
        @endif
        
        <div class="text-center mt-8">
             <a href="{{ route('user.recommendation.intro') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                Ulangi Kuesioner
            </a>
        </div>
    </div>
</div>
@endsection