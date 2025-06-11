@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard Overview</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card: Jumlah Instrumen Investasi --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-gray-100">
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Instruments</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $jumlahInstrument }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <i class="fas fa-briefcase text-2xl"></i> {{-- Ikon --}}
            </div>
        </div>

        {{-- Card: Jumlah Kriteria --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-gray-100">
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Criterias</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $jumlahKriteria }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                <i class="fas fa-sliders-h text-2xl"></i> {{-- Ikon --}}
            </div>
        </div>

        {{-- Card: Jumlah Data Perhitungan --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-gray-100">
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Calculations</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $jumlahPerhitungan }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <i class="fas fa-calculator text-2xl"></i> {{-- Ikon --}}
            </div>
        </div>

        {{-- Card: Paling Banyak Direkomendasikan (placeholder/total users) --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-gray-100">
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $jumlahUser ?? 'N/A' }}</p> {{-- Asumsi ada variabel $jumlahUser --}}
            </div>
            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                <i class="fas fa-users text-2xl"></i> {{-- Ikon --}}
            </div>
        </div>
    </div>

    {{-- BAGIAN PALING BANYAK DIREKOMENDASIKAN DIHAPUS DARI SINI --}}

    {{-- Contoh Tambahan: Bagian Grafik (Placeholder) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Calculation Trends (Placeholder)</h3>
            <p class="text-gray-600 text-sm">Grafik pertumbuhan perhitungan dari waktu ke waktu bisa muncul di sini.</p>
            <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                [Chart Placeholder]
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">User Activity (Placeholder)</h3>
            <p class="text-gray-600 text-sm">Statistik aktivitas pengguna seperti login, rekomendasi terbanyak, dll.</p>
            <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                [Another Chart/Stats Placeholder]
            </div>
        </div>
    </div>
@endsection