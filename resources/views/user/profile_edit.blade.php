@extends('user.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">

    <header class="mb-8">
        {{-- Tombol kembali --}}
        <a href="{{ route('profile') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke Profil
        </a>
        <h1 class="text-3xl font-bold text-gray-800">
            Edit Profil
        </h1>
        <p class="mt-1 text-md text-gray-600">
            Perbarui informasi akun dan password Anda di sini.
        </p>
    </header>

    <div class="space-y-6">
        {{-- Card untuk Update Informasi Profil --}}
        <div class="p-4 sm:p-8 bg-white shadow-md sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900">
                    Profile Information
                </h2>
                
                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    </div>

                    <div>
                        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                        <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700">Save</button>
                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-gray-600">Tersimpan.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Card untuk Update Password --}}
        <div class="p-4 sm:p-8 bg-white shadow-md sm:rounded-lg">
            <div class="max-w-xl">
                 <h2 class="text-lg font-medium text-gray-900">
                    Update Password
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
                </p>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block font-medium text-sm text-gray-700">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="current-password" />
                    </div>
                    <div>
                        <label for="password" class="block font-medium text-sm text-gray-700">Password Baru</label>
                        <input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="new-password" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="new-password" />
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700">Save</button>
                         @if (session('status') === 'password-updated')
                            <p class="text-sm text-gray-600">Tersimpan.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
