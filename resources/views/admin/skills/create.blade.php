@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Create Skill</h1>

    <form action="{{ route('skills.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control">
                <option value="">No Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success action-btn">Create</button>
        <a href="{{ route('skills.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
