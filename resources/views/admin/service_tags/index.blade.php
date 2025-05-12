@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Service Tags</h1>

    <a href="{{ route('service-tags.create') }}" class="btn btn-primary mb-3 action-btn">Create New Tag</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">ID</th>
                <th class="table-cell">Name</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td class="table-cell">{{ $tag->id }}</td>
                    <td class="table-cell">{{ $tag->name }}</td>
                    <td class="table-cell">
                        <a href="{{ route('service-tags.edit', $tag) }}" class="btn btn-warning btn-sm action-btn">Edit</a>
                        <form action="{{ route('service-tags.destroy', $tag) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this tag?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm action-btn" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
