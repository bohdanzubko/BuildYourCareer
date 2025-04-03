@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Jobs</h1>
    <a href="{{ route('jobs.create') }}" class="btn btn-primary mb-3 action-btn">Add new job</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">Job Title</th>
                <th class="table-cell">Location</th>
                <th class="table-cell">Salary Range</th>
                <th class="table-cell">Category</th>
                <th class="table-cell">Employer</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
                <tr>
                    <td class="table-cell">{{ $job->title }}</td>
                    <td class="table-cell">{{ $job->location }}</td>
                    <td class="table-cell">{{ $job->salary_min }} - {{ $job->salary_max }}</td>
                    <td class="table-cell">{{ $job->category->name }}</td>
                    <td class="table-cell">{{ $job->employer->name }}</td>
                    <td class="table-cell">
                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning action-btn">Edit</a>
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
