@extends('admin.app')

@section('content')
<div class="container mt-4">
    <h1>Manage Sub-Criterias for: {{ $criteria->name }} ({{ $criteria->code }})</h1>
    <a href="{{ route('admin.criterias.index') }}" class="btn btn-secondary mb-3">Back to Criterias</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-3 mb-4">
        <h5>Add New Sub-Criteria</h5>
        <form action="{{ route('admin.criterias.subcriterias.store', $criteria->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="option_text" class="form-label">Option Text</label>
                <input type="text" class="form-control" id="option_text" name="option_text" required>
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" min="0" max="100" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Sub-Criteria</button>
        </form>
    </div>

    <h5>Existing Sub-Criterias</h5>
    @if($subCriterias->isEmpty())
        <p>No sub-criterias defined yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Option Text</th>
                    <th>Weight</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subCriterias as $subCriteria)
                    <tr>
                        <td>
                            <form action="{{ route('admin.subcriterias.update', $subCriteria->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="text" name="option_text" value="{{ $subCriteria->option_text }}" class="form-control d-inline-block w-auto">
                                <input type="number" name="weight" value="{{ $subCriteria->weight }}" class="form-control d-inline-block w-auto" min="0" max="100">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                        <td>{{ $subCriteria->weight }}</td>
                        <td>
                            <form action="{{ route('admin.subcriterias.destroy', $subCriteria->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection