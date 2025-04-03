@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3 action-btn">Add new user</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">#</th>
                <th class="table-cell">Name</th>
                <th class="table-cell">Email</th>
                <th class="table-cell">Role</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="table-cell">{{ $user->id }}</td>
                    <td class="table-cell">{{ $user->name }}</td>
                    <td class="table-cell">{{ $user->email }}</td>
                    <td class="table-cell">{{ $user->role }}</td>
                    <td class="table-cell">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning action-btn">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
