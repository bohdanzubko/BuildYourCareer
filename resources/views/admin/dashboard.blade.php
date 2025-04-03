@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-2xl font-semibold text-gray-800 dark:text-gray-200">Admin Panel</h1>
    
    <!-- Dashboard Links -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('users.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-bold">Users</h2>
            <p class="mt-2 text-sm">Manage users of the platform.</p>
        </a>

        <a href="{{ route('services.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-bold">Services</h2>
            <p class="mt-2 text-sm">Manage available services.</p>
        </a>

        <a href="{{ route('categories.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-bold">Categories</h2>
            <p class="mt-2 text-sm">Manage service categories.</p>
        </a>

        <a href="{{ route('jobs.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-bold">Jobs</h2>
            <p class="mt-2 text-sm">View and manage job listings.</p>
        </a>

        <a href="{{ route('job_offers.index') }}" class="bg-teal-500 hover:bg-teal-600 text-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-bold">Job Offers</h2>
            <p class="mt-2 text-sm">Manage job offers made by employers.</p>
        </a>

        <a href="{{ route('job_requests.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-bold">Job Requests</h2>
            <p class="mt-2 text-sm">Manage job offers made by workers.</p>
        </a>

        <a href="{{ route('settings.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-lg font-bold">Settings</h2>
            <p class="mt-2 text-sm">Manage platform settings.</p>
        </a>
    </div>
</div>
@endsection
