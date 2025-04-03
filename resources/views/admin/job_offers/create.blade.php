@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Create Job Offer</h1>

    <form action="{{ route('job_offers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="job_id" class="form-label">Job</label>
            <select class="form-control @error('job_id') is-invalid @enderror" id="job_id" name="job_id" required>
                <option value="">Select Job</option>
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}" {{ old('job_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
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
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="offer_price" class="form-label">Offer Price</label>
            <input type="text" class="form-control @error('offer_price') is-invalid @enderror" id="offer_price" name="offer_price" value="{{ old('offer_price') }}" required>
            @error('offer_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success action-btn">Save</button>
        <a href="{{ route('job_offers.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
