@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">User Profiles</h1>

    <a href="{{ route('user-profiles.create') }}" class="btn btn-primary mb-3 action-btn">Create New Profile</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">User</th>
                <th class="table-cell">Phone</th>
                <th class="table-cell">Location</th>
                <th class="table-cell">Website</th>
                <th class="table-cell">Company</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($profiles as $profile)
                <tr>
                    <td class="table-cell">{{ $profile->user->name ?? 'N/A' }}</td>
                    <td class="table-cell">{{ $profile->phone }}</td>
                    <td class="table-cell">{{ $profile->location }}</td>
                    <td class="table-cell">{{ $profile->website }}</td>
                    <td class="table-cell">{{ $profile->company_name }}</td>
                    <td class="table-cell">
                        <a href="{{ route('user-profiles.edit', $profile) }}" class="btn btn-sm btn-warning action-btn">Edit</a>
                        <form action="{{ route('user-profiles.destroy', $profile) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this profile?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger action-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
