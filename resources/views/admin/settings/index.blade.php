@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Settings</h1>
    <a href="{{ route('settings.create') }}" class="btn btn-primary mb-3 action-btn">Add new setting</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">Setting Key</th>
                <th class="table-cell">Setting Value</th>
                <th class="table-cell">Description</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($settings as $setting)
                <tr>
                    <td class="table-cell">{{ $setting->setting_key }}</td>
                    <td class="table-cell">{{ $setting->setting_value }}</td>
                    <td class="table-cell">{{ $setting->description }}</td>
                    <td class="table-cell"> 
                        <a href="{{ route('settings.edit', $setting->setting_key) }}" class="btn btn-warning action-btn">Edit</a>
                        <form action="{{ route('settings.destroy', $setting->setting_key) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
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
