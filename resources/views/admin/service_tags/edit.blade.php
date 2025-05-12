@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Edit Service Tag</h1>

    <form action="{{ route('service-tags.update', $serviceTag) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tag Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $serviceTag->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success action-btn">Update</button>
        <a href="{{ route('service-tags.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
