@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Edit User Profile</h1>

    <form action="{{ route('user-profiles.update', $userProfile) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Avatar URL</label>
            <input type="text" name="avatar_url" class="form-control" value="{{ old('avatar_url', $userProfile->avatar_url) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-control">{{ old('bio', $userProfile->bio) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $userProfile->location) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $userProfile->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Website</label>
            <input type="text" name="website" class="form-control" value="{{ old('website', $userProfile->website) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $userProfile->company_name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Company Description</label>
            <textarea name="company_description" class="form-control">{{ old('company_description', $userProfile->company_description) }}</textarea>
        </div>

        <button class="btn btn-success action-btn">Update</button>
        <a href="{{ route('user-profiles.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
