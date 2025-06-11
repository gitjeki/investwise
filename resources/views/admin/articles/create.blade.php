@extends('layouts.admin')

@section('title', 'Tambah Artikel Baru')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Buat Artikel Baru</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.articles.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Judul Artikel</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-bold mb-2">Kategori</label>
                <input type="text" name="category" id="category" value="{{ old('category') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Emas, Saham, Reksadana" required>
            </div>

            <div class="mb-4">
                <label for="body" class="block text-gray-700 font-bold mb-2">Isi Artikel</label>
                <textarea name="body" id="body" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('body') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">URL Gambar</label>
                <input type="url" name="image" id="image" value="{{ old('image') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://example.com/image.jpg">
            </div>
            
            <div class="mb-4">
                <label for="published_at" class="block text-gray-700 font-bold mb-2">Tanggal Publikasi (Opsional)</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-600 mt-1">Kosongkan jika ingin disimpan sebagai draft.</p>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.articles.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Artikel</button>
            </div>
        </form>
    </div>
</div>
@endsection
