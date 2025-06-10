@extends('user.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">

    {{-- KARTU INFORMASI PROFIL --}}
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="flex items-center space-x-6">
            {{-- Placeholder untuk Foto Profil --}}
            <div class="flex-shrink-0">
                <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            {{-- Nama dan Email --}}
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
                <p class="text-lg text-gray-600 mt-1">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    {{-- MENU PENGATURAN AKUN (TAMPILAN BARU) --}}
    <div class="bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-bold p-6 border-b">Pengaturan Akun</h2>
        <div class="p-4 space-y-2">
            {{-- Link ke Halaman Edit Profil --}}
            <a href="{{ route('profile.edit') }}" class="flex items-center p-4 text-gray-700 rounded-lg hover:bg-green-50 transition duration-200 group">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-800">Edit Profil</h3>
                    <p class="text-sm text-gray-500">Perbarui nama, email, dan password Anda.</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            {{-- Link ke Halaman History --}}
            <a href="{{ route('profile.history') }}" class="flex items-center p-4 text-gray-700 rounded-lg hover:bg-green-50 transition duration-200 group">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-800">History</h3>
                    <p class="text-sm text-gray-500">Lihat riwayat perhitungan SPK Anda.</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            {{-- Form untuk Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center p-4 text-gray-700 rounded-lg hover:bg-red-50 transition duration-200 group">
                    <div class="p-2 bg-red-100 rounded-lg">
                         <svg class="w-6 h-6 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    </div>
                    <div class="ml-4 text-left">
                        <h3 class="font-semibold text-red-700 group-hover:text-red-800">Log Out</h3>
                        <p class="text-sm text-gray-500">Keluar dari sesi akun Anda saat ini.</p>
                    </div>
                     <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
