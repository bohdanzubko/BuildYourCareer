@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Job Requests</h1>
    <a href="{{ route('job_requests.create') }}" class="btn btn-primary mb-3 action-btn">Add new job request</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">Job</th>
                <th class="table-cell">Employer</th>
                <th class="table-cell">Status</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobRequests as $jobRequest)
                <tr>
                    <td class="table-cell">{{ $jobRequest->job->title }}</td>
                    <td class="table-cell">{{ $jobRequest->user->name }}</td>
                    <td class="table-cell">{{ $jobRequest->status }}</td>
                    <td class="table-cell">
                        <a href="{{ route('job_requests.edit', $jobRequest->id) }}" class="btn btn-warning action-btn">Edit</a>
                        <form action="{{ route('job_requests.destroy', $jobRequest->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
