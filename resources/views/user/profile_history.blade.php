@extends('user.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row gap-8">

        {{-- KOLOM KANAN: KONTEN UTAMA (HISTORY) --}}
        <main class="w-full md:w-3/4">
            <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Riwayat Perhitungan SPK</h2>
                <p class="text-gray-600">
                    Fitur ini sedang dalam pengembangan. Nanti di sini akan ditampilkan daftar hasil perhitungan SPK yang pernah Anda lakukan.
                </p>
                {{-- Nanti di sini akan ada tabel atau daftar riwayat --}}
            </div>
        </main>

    </div>
</div>
@endsection