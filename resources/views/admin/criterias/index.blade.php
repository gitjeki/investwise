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
@endsection