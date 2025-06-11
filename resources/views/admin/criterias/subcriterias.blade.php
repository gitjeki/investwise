@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Sub-Criterias for: {{ $criteria->name }} ({{ $criteria->code }})</h1>
    <a href="{{ route('admin.criterias.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Back to Criterias</a>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
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

    {{-- Form Tambah Sub-Kriteria --}}
    <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-100 mb-8">
        <h5 class="text-xl font-semibold text-gray-800 mb-4">Add New Sub-Criteria</h5>
        <form action="{{ route('admin.criterias.subcriterias.store', $criteria->id) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label for="option_text" class="block text-gray-700 text-sm font-bold mb-2">Sub Criteria:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" id="option_text" name="option_text" required>
            </div>
            <div class="mb-6">
                <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Weight:</label>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" id="weight" name="weight" min="0" max="100" required>
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full shadow-md transition-all duration-200">Add Sub-Criteria</button>
        </form>
    </div>

    {{-- Daftar Sub-Kriteria yang Ada --}}
    <h5 class="text-xl font-semibold text-gray-800 mb-4">Existing Sub-Criterias</h5>
    @if($subCriterias->isEmpty())
        <p class="text-gray-600">No sub-criterias defined yet.</p>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sub Criteria</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Weight</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subCriterias as $subCriteria)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <form action="{{ route('admin.subcriterias.update', $subCriteria->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="option_text" value="{{ $subCriteria->option_text }}" class="shadow appearance-none border rounded py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm w-40">
                                    <input type="number" name="weight" value="{{ $subCriteria->weight }}" class="shadow appearance-none border rounded py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm w-20" min="0" max="100">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded-full shadow-sm transition-all duration-200 text-sm">Update</button>
                                </form>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $subCriteria->weight }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{-- Tombol Delete yang memicu modal --}}
                                <button type="button" onclick="openDeleteModal('{{ $subCriteria->id }}', '{{ $subCriteria->option_text }}')" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Modal Konfirmasi Delete (Sama seperti di investment_instruments/index.blade.php) --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm">
            <div class="text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Are you sure you want to delete <strong id="deleteItemName" class="font-semibold text-gray-700"></strong>?
                </h3>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                        No, cancel
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal (disesuaikan untuk route subcriterias.destroy)
        function openDeleteModal(itemId, itemName) {
            const modal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const deleteItemName = document.getElementById('deleteItemName');

            // Set action URL for the form
            deleteForm.action = "{{ route('admin.subcriterias.destroy', ':id') }}".replace(':id', itemId);
            
            // Set item name in the modal body
            deleteItemName.textContent = itemName;

            modal.classList.remove('hidden'); // Show the modal
        }

        // Fungsi untuk menutup modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden'); // Hide the modal
        }

        // Menutup modal jika user mengklik di luar area konten modal
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                closeDeleteModal();
            }
        }
    </script>
@endsection