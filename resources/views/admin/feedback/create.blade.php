@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Create Feedback</h1>

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">User</label>
            <select name="user_id" class="form-control">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Job</label>
            <select name="job_id" class="form-control">
                @foreach ($jobs as $job)
                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Comment</label>
            <textarea name="comment" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success action-btn">Create</button>
        <a href="{{ route('feedback.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
