@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Service Requests</h1>

    <a href="{{ route('service-requests.create') }}" class="btn btn-primary mb-3 action-btn">Create New Request</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">ID</th>
                <th class="table-cell">User</th>
                <th class="table-cell">Service</th>
                <th class="table-cell">Area (m²)</th>
                <th class="table-cell">Price</th>
                <th class="table-cell">Status</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td class="table-cell">{{ $request->id }}</td>
                    <td class="table-cell">{{ $request->user->name ?? 'N/A' }}</td>
                    <td class="table-cell">{{ $request->service->name ?? 'N/A' }}</td>
                    <td class="table-cell">{{ $request->area }}</td>
                    <td class="table-cell">{{ $request->estimated_price }}</td>
                    <td class="table-cell">{{ ucfirst(str_replace('_', ' ', $request->status)) }}</td>
                    <td class="table-cell">
                        <a href="{{ route('service-requests.edit', $request) }}" class="btn btn-warning btn-sm action-btn">Edit</a>
                        <form action="{{ route('service-requests.destroy', $request) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this request?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
