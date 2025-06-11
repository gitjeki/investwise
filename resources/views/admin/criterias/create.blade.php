@extends('layouts.admin')
@section('title', 'Tambah Kriteria')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Criteria</h1>
        <a href="{{ route('admin.criterias.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Back to List</a>

        <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-100">
            {{-- Menggunakan blok error Tailwind CSS --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Ada masalah dengan input Anda.</span>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.criterias.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kriteria:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                </div>

                <div class="mb-5">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Tipe Kriteria:</label>
                    <select name="type" id="type"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                        <option value="">Pilih Tipe</option>
                        <option value="benefit" {{ old('type') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('type') == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="question" class="block text-gray-700 text-sm font-bold mb-2">Pertanyaan Kriteria (untuk user):</label>
                    <textarea name="question" id="question" rows="3"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">{{ old('question') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Ini adalah pertanyaan yang akan dilihat user pada alur rekomendasi.</p>
                </div>

                <div class="flex items-center justify-start space-x-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-200 shadow-md">Simpan</button>
                    <a href="{{ route('admin.criterias.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold py-2 px-4 rounded-full transition-all duration-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection