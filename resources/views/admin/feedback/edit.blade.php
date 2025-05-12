@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Edit Feedback</h1>

    <form action="{{ route('feedback.update', $feedback) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" value="{{ old('rating', $feedback->rating) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Comment</label>
            <textarea name="comment" class="form-control">{{ old('comment', $feedback->comment) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success action-btn">Update</button>
        <a href="{{ route('feedback.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
