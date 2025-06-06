@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Create New Service</h1>

    <form action="{{ route('services.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success action-btn">Create</button>
        <a href="{{ route('services.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
