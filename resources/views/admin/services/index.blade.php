@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class=" page-title mb-4">Services</h1>
    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3 action-btn">Add new service</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">#</th>
                <th class="table-cell">Name</th>
                <th class="table-cell">Description</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td class="table-cell">{{ $service->id }}</td>
                    <td class="table-cell">{{ $service->name }}</td>
                    <td class="table-cell">{{ $service->description }}</td>
                    <td class="table-cell">
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning action-btn">Edit</a>
                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger action-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
