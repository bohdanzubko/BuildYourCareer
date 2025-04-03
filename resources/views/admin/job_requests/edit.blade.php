@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class=" page-title mb-4">Edit Job Request</h1>

    <form action="{{ route('job_requests.update', $jobRequest->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="job_id" class="form-label">Job</label>
            <select class="form-control @error('job_id') is-invalid @enderror" id="job_id" name="job_id" required>
                <option value="">Select Job</option>
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}" {{ old('job_id', $jobRequest->job_id) == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                @endforeach
            </select>
            @error('job_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Employer</label>
            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                <option value="">Select Employer</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $jobRequest->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="viewed" {{ old('status') == 'viewed' ? 'selected' : '' }}>Viewed</option>
                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="declined" {{ old('status') == 'declined' ? 'selected' : '' }}>Declined</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success action-btn">Update</button>
        <a href="{{ route('job_requests.index') }}" class="btn btn-danger action-btn">Cancel</a>        
    </form>
</div>
@endsection
