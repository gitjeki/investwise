@extends('user.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- Bagian Header --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Articles and News</h1>
        <p class="mt-4 text-lg text-gray-600">The latest industry news, interviews, investment, and resources.</p>
    </div>

    {{-- Grid untuk Kartu Artikel --}}
    @if($articles->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            {{-- Loop untuk setiap artikel dari controller --}}
            @foreach ($articles as $article)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out">
                {{-- Gambar Artikel --}}
                {{-- Gunakan kolom 'image_path' dari database --}}
                <a href="#">
                    @if ($article->image_path)
                        {{-- Gunakan Storage::url() untuk path file, atau langsung jika itu adalah URL eksternal lama --}}
                        <img src="{{ filter_var($article->image_path, FILTER_VALIDATE_URL) ? $article->image_path : Storage::url($article->image_path) }}" 
                             alt="Gambar artikel tentang {{ $article->title }}" class="w-full h-48 object-cover">
                    @else
                        {{-- Placeholder jika tidak ada gambar --}}
                        <img src="https://placehold.co/600x400/EAF4E4/333?text=No+Image" alt="No Article Image" class="w-full h-48 object-cover">
                    @endif
                </a>
                
                <div class="p-6">
                    {{-- Kategori dan Tanggal --}}
                    <div class="flex justify-between items-center text-sm text-gray-500 mb-2">
                        <p class="font-semibold text-green-600">{{ $article->category }}</p>
                        {{-- Perbaikan untuk published_at yang bisa null --}}
                        <p>{{ $article->published_at ? $article->published_at->format('d M Y') : 'Draft' }}</p>
                    </div>

                    {{-- Judul Artikel --}}
                    <h2 class="text-xl font-bold text-gray-800 mb-3 leading-tight">
                        <a href="#" class="hover:text-green-700 transition-colors duration-200">
                            {{ $article->title }}
                        </a>
                    </h2>

                    {{-- Deskripsi Singkat --}}
                    <p class="text-gray-600 text-base mb-4">
                        {{ Str::limit($article->body, 100) }}
                    </p>

                    {{-- Link "Read More" dengan Ikon Panah --}}
                    <a href="#" class="inline-flex items-center font-semibold text-green-600 hover:text-green-800">
                        <span>Read more</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    @else
        <div class="text-center py-16">
            <p class="text-gray-500 text-lg">Saat ini belum ada artikel yang dipublikasikan.</p>
            <p class="text-gray-400 mt-2">Silakan cek kembali nanti.</p>
        </div>
    @endif

    {{-- Tombol Load More (bisa disembunyikan jika artikel sedikit) --}}
    @if($articles->count() > 4)
        <div class="text-center mt-12">
            <button class="bg-purple-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-purple-700 transition-colors duration-300">
                Load more
            </button>
        </div>
    @endif

</div>
@endsection