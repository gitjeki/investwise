@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Jumlah Instrument Investasi</h3>
            <p class="text-3xl font-bold mt-2">{{ $jumlahInstrument }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Jumlah Kriteria</h3>
            <p class="text-3xl font-bold mt-2">{{ $jumlahKriteria }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Jumlah Data Perhitungan</h3>
            <p class="text-3xl font-bold mt-2">{{ $jumlahPerhitungan }}</p>
        </div>
        <div class="div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h3 class="text-gray-800 text-lg font-bold mb-4">Paling Banyak Direkomendasikan (Terakhir Dihitung)</h3>

    @if (!empty($rekomendasiTeratas))
        <div class="table-responsive">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-50 text-gray-600 text-xs font-semibold uppercase tracking-wider">Rank</th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-50 text-gray-600 text-xs font-semibold uppercase tracking-wider">Alternative</th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-50 text-gray-600 text-xs font-semibold uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-50 text-gray-600 text-xs font-semibold uppercase tracking-wider">Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekomendasiTeratas as $altName => $data)
                        <tr>
                            <td class="px-4 py-2 border-b border-gray-200 text-sm">{{ $data['rank'] }}</td>
                            <td class="px-4 py-2 border-b border-gray-200 text-sm font-medium">{{ $altName }}</td>
                            <td class="px-4 py-2 border-b border-gray-200 text-sm">{{ $data['type'] }}</td>
                            <td class="px-4 py-2 border-b border-gray-200 text-sm">{{ number_format($data['score'], 3) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600 text-sm">Belum ada data perhitungan rekomendasi terbaru.</p>
    @endif
</div>
    </div>
@endsection