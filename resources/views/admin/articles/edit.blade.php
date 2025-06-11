@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Artikel: {{ $article->title }}</h1>

    <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-100">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada masalah dengan input Anda.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Menggunakan metode PUT untuk update --}}

            <div class="mb-5">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Artikel:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
            </div>

            <div class="mb-5">
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                <input type="text" name="category" id="category" value="{{ old('category', $article->category) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="Contoh: Emas, Saham, Reksadana" required>
            </div>

            <div class="mb-5">
                <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Isi Artikel:</label>
                <textarea name="body" id="body" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">{{ old('body', $article->body) }}</textarea>
            </div>

            <div class="mb-5">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Upload Gambar Baru:</label>
                <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF. Max 2MB.</p>
                @if ($article->image_path)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Gambar saat ini:</p>
                        <img src="{{ Storage::url($article->image_path) }}" alt="Current Article Image" class="w-32 h-auto rounded-lg shadow-md mt-1">
                    </div>
                @endif
            </div>
            
            <div class="mb-6">
                <label for="published_at" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Publikasi (Opsional):</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-sm text-gray-600 mt-1">Kosongkan jika ingin disimpan sebagai draft.</p>
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.articles.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold py-2 px-4 rounded-full transition-all duration-200">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-200 shadow-md">Update Artikel</button>
            </div>
        </form>
    </div>
</div>
@endsection