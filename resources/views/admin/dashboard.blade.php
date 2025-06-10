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
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Paling Banyak direkomendasikan</h3>
            <p class="text-3xl font-bold mt-2">{{ $rekomendasiTeratas }}</p>
        </div>
    </div>
@endsection