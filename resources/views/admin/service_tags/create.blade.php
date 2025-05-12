@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Create Service Tag</h1>

    <form action="{{ route('service-tags.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tag Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success action-btn">Create</button>
        <a href="{{ route('service-tags.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
