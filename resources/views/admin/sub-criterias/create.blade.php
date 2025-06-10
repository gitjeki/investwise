@extends('layouts.admin')
@section('title', 'Tambah Sub Kriteria')
@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Sub Kriteria Baru</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            @include('admin.partials.errors')
            <form action="{{ route('admin.sub-criterias.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="criteria_id" class="block text-gray-700 font-bold mb-2">Kriteria Induk:</label>
                    <select name="criteria_id" id="criteria_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach($criterias as $criteria)
                            <option value="{{ $criteria->id }}" {{ old('criteria_id') == $criteria->id ? 'selected' : '' }}>{{ $criteria->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nama Sub Kriteria:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="weight" class="block text-gray-700 font-bold mb-2">Bobot:</label>
                    <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
                    <a href="{{ route('admin.sub-criterias.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection