@extends('user.app') {{-- Atau layout utama Anda --}}

@section('content')
<div class="content container">
    <h1 class="mb-4 text-center">My Calculation History</h1>

    @forelse($histories as $history)
        <div class="card p-4 mb-4">
            <h4 class="mb-3">Calculation on {{ $history->created_at->format('d M Y H:i') }}</h4>

            <h5 class="mt-4">Your Preferences:</h5>
            <ul>
                @foreach($history->user_preferences as $criteria_id => $sub_criteria_id)
                    @php
                        $criteria = $criterias[$criteria_id] ?? null;
                        $subCriteria = $subCriterias[$sub_criteria_id] ?? null;
                    @endphp
                    @if($criteria && $subCriteria)
                        <li>{{ $criteria->name }}: {{ $subCriteria->option_text }} (Weight: {{ $subCriteria->weight }})</li>
                    @endif
                @endforeach
            </ul>

            <h5 class="mt-4">Top 5 Recommendations:</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Alternative</th>
                            <th>Jenis</th>
                            <th>Final Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history->calculated_rankings as $altName => $data)
                            <tr>
                                <td><span class="badge {{ $data['rank'] == 1 ? 'bg-success' : 'bg-secondary' }}">{{ $data['rank'] }}</span></td>
                                <td>{{ $altName }}</td>
                                <td>{{ $data['type'] }}</td>
                                <td>{{ number_format($data['score'], 3) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            You have no previous calculation history.
        </div>
    @endforelse
</div>
@endsection