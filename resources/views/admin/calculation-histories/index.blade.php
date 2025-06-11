@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Calculation Histories</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        User
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        User Preferences
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Top 5 Recommendations
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $history->id }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $history->user->name ?? 'N/A' }} ({{ $history->user->email ?? 'N/A' }})
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $history->created_at->format('d M Y H:i:s') }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <ul class="list-disc list-inside">
                                @foreach($history->user_preferences as $criteria_id => $sub_criteria_id)
                                    @php
                                        $criteria = $criterias[$criteria_id] ?? null;
                                        $subCriteria = $subCriterias[$sub_criteria_id] ?? null;
                                    @endphp
                                    @if($criteria && $subCriteria)
                                        <li>{{ $criteria->code }}: {{ $subCriteria->option_text }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <ul class="list-disc list-inside">
                                @foreach($history->calculated_rankings as $altName => $data)
                                    <li>{{ $data['rank'] }}. {{ $altName }} (Score: {{ number_format($data['score'], 3) }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{-- Tombol Delete yang memicu modal --}}
                            <button type="button" onclick="openDeleteModal('{{ $history->id }}', 'History ID: {{ $history->id }} (User: {{ $history->user->name ?? 'N/A' }})')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                            No calculation histories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

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
    // Fungsi untuk membuka modal (disesuaikan untuk route calculation-histories.destroy)
    function openDeleteModal(itemId, itemName) {
        const modal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteItemName = document.getElementById('deleteItemName');

        // Set action URL for the form
        deleteForm.action = "{{ route('admin.calculation-histories.destroy', ':id') }}".replace(':id', itemId);

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