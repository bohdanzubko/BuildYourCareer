@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Job Confirmations</h1>

    <a href="{{ route('job-confirmations.create') }}" class="btn btn-primary mb-3 action-btn">Add New Confirmation</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">ID</th>
                <th class="table-cell">User</th>
                <th class="table-cell">Job</th>
                <th class="table-cell">Created At</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($confirmations as $confirmation)
                <tr>
                    <td class="table-cell">{{ $confirmation->id }}</td>
                    <td class="table-cell">{{ $confirmation->user->name ?? 'N/A' }}</td>
                    <td class="table-cell">{{ $confirmation->job->title ?? 'N/A' }}</td>
                    <td class="table-cell">{{ $confirmation->created_at }}</td>
                    <td class="table-cell">
                        <a href="{{ route('job-confirmations.edit', $confirmation) }}" class="btn btn-warning btn-sm action-btn">Edit</a>
                        <form action="{{ route('job-confirmations.destroy', $confirmation) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this confirmation?')">
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
