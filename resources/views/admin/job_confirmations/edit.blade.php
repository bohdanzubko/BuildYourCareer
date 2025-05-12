@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Edit Job Confirmation</h1>

    <form action="{{ route('job-confirmations.update', $jobConfirmation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected($jobConfirmation->user_id == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="job_id" class="form-label">Job</label>
            <select name="job_id" id="job_id" class="form-control">
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}" @selected($jobConfirmation->job_id == $job->id)>{{ $job->title }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success action-btn">Update</button>
        <a href="{{ route('job-confirmations.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
