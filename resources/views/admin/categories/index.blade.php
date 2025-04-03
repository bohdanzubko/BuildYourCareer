@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3 action-btn">Add new category</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">#</th>
                <th class="table-cell">Name</th>
                <th class="table-cell">Description</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="table-cell">{{ $category->id }}</td>
                    <td class="table-cell">{{ $category->name }}</td>
                    <td class="table-cell">{{ $category->description }}</td>
                    <td class="table-cell">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning action-btn">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger action-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
