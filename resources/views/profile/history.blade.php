@extends('user.app') {{-- Gunakan layout utama Anda --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 text-center">My Calculation History</h1>

    @forelse($histories as $history)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-gray-700">Calculation on {{ $history->created_at->format('d M Y H:i:s') }}</h4>
                <span class="text-sm text-gray-500">ID: {{ $history->id }}</span>
            </div>

            <div class="mb-4">
                <h5 class="text-lg font-semibold text-gray-700 mb-2">Your Preferences:</h5>
                <ul class="list-disc list-inside text-gray-600">
                    @foreach($history->user_preferences as $criteria_id => $sub_criteria_id)
                        @php
                            $criteria = $criterias[$criteria_id] ?? null;
                            $subCriteria = $subCriterias[$sub_criteria_id] ?? null;
                        @endphp
                        @if($criteria && $subCriteria)
                            <li><strong>{{ $criteria->name }} ({{ $criteria->code }}):</strong> {{ $subCriteria->option_text }} (Weight: {{ $subCriteria->weight }})</li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div>
                <h5 class="text-lg font-semibold text-gray-700 mb-2">Top 5 Recommendations:</h5>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rank</th>
                                <th class="px-4 py-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alternative</th>
                                <th class="px-4 py-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                                <th class="px-4 py-2 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Final Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history->calculated_rankings as $altName => $data)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b text-sm text-gray-900">{{ $data['rank'] }}</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-900 font-medium">{{ $altName }}</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-900">{{ $data['type'] }}</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-900">{{ number_format($data['score'], 3) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative text-center">
            Belum ada riwayat perhitungan. Mulai rekomendasi pertama Anda!
        </div>
    @endforelse
</div>
@endsection