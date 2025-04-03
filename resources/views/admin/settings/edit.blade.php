@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Edit Setting</h1>

    <form action="{{ route('settings.update', $setting->setting_key) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="setting_key" class="form-label">Setting Key</label>
            <input type="text" class="form-control @error('setting_key') is-invalid @enderror" id="setting_key" name="setting_key" value="{{ $setting->setting_key }}" readonly required>
            @error('setting_key')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="setting_value" class="form-label">Setting Value</label>
            <input type="text" class="form-control @error('setting_value') is-invalid @enderror" id="setting_value" name="setting_value" value="{{ old('setting_value', $setting->setting_value) }}" required>
            @error('setting_value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $setting->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success action-btn">Update</button>
        <a href="{{ route('settings.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
