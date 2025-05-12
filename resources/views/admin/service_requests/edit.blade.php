@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Edit Service Request</h1>

    <form action="{{ route('service-requests.update', $serviceRequest) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected($serviceRequest->user_id == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="service_id" class="form-label">Service</label>
            <select name="service_id" id="service_id" class="form-control">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" @selected($serviceRequest->service_id == $service->id)>{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $serviceRequest->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Area (m²)</label>
            <input type="number" step="0.01" name="area" id="area" class="form-control" value="{{ old('area', $serviceRequest->area) }}">
        </div>

        <div class="mb-3">
            <label for="estimated_price" class="form-label">Estimated Price</label>
            <input type="number" step="0.01" name="estimated_price" id="estimated_price" class="form-control" value="{{ old('estimated_price', $serviceRequest->estimated_price) }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach(['pending', 'in_progress', 'completed'] as $status)
                    <option value="{{ $status }}" @selected($serviceRequest->status === $status)>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success action-btn">Update</button>
        <a href="{{ route('service-requests.index') }}" class="btn btn-danger action-btn">Cancel</a>
    </form>
</div>
@endsection
