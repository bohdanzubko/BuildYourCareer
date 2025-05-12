@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Skills</h1>

    <a href="{{ route('skills.create') }}" class="btn btn-primary mb-3 action-btn">Add New Skill</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">ID</th>
                <th class="table-cell">Name</th>
                <th class="table-cell">Category</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($skills as $skill)
                <tr>
                    <td class="table-cell">{{ $skill->id }}</td>
                    <td class="table-cell">{{ $skill->name }}</td>
                    <td class="table-cell">{{ $skill->category->name ?? 'N/A' }}</td>
                    <td class="table-cell">
                        <a href="{{ route('skills.edit', $skill) }}" class="btn btn-warning btn-sm action-btn">Edit</a>
                        <form action="{{ route('skills.destroy', $skill) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this skill?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
