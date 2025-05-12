@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Feedback</h1>

    <a href="{{ route('feedback.create') }}" class="btn btn-primary mb-3 action-btn">Add New Feedback</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">User</th>
                <th class="table-cell">Job</th>
                <th class="table-cell">Rating</th>
                <th class="table-cell">Comment</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedback as $item)
                <tr>
                    <td class="table-cell">{{ $item->user->name ?? 'N/A' }}</td>
                    <td class="table-cell">{{ $item->job->title ?? 'N/A' }}</td>
                    <td class="table-cell">{{ $item->rating }}</td>
                    <td class="table-cell">{{ Str::limit($item->comment, 50) }}</td>
                    <td class="table-cell">
                        <a href="{{ route('feedback.edit', $item) }}" class="btn btn-warning btn-sm action-btn">Edit</a>
                        <form action="{{ route('feedback.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this feedback?')">
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
