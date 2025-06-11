<<<<<<< HEAD
@extends('admin.app') {{-- Asumsikan Anda punya layout admin.app --}}

@section('content')
<div class="container mt-4">
    <h1>Manage Criterias</h1>
    <a href="{{ route('admin.criterias.create') }}" class="btn btn-primary mb-3">Add New Criteria</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Question</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($criterias as $criteria)
                <tr>
                    <td>{{ $criteria->code }}</td>
                    <td>{{ $criteria->name }}</td>
                    <td>{{ $criteria->type }}</td>
                    <td>{{ $criteria->question }}</td>
                    <td>
                        <a href="{{ route('admin.criterias.edit', $criteria->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('admin.criterias.subcriterias.index', $criteria->id) }}" class="btn btn-sm btn-info">Manage Sub-Criterias</a>
                        <form action="{{ route('admin.criterias.destroy', $criteria->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
=======
@extends('layouts.admin')
@section('title', 'Data Kriteria')
@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manajemen Kriteria</h1>
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <a href="{{ route('admin.criterias.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Kriteria</a>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kriteria</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bobot</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criterias as $criteria)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $criteria->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $criteria->weight }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="{{ route('admin.criterias.edit', $criteria) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.criterias.destroy', $criteria) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
>>>>>>> f5d8e32cdfdba13b8ef8294983eae2603b59b989
@endsection