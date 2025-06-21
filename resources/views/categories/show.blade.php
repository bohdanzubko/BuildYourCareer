@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyan-700 dark:text-cyan-300">{{ $category->name }}</h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $category->description }}</p>
    </div>

    @php
        $user = auth()->user();
        $isEmployer = $user && $user->role === 'employer';
        $isWorker = $user && $user->role === 'worker';
        $isAdmin = $user && $user->role === 'admin';
    @endphp

    {{-- Вакансії (гості, робітники, адмін) --}}
    @if(!$user || $isWorker || $isAdmin)
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 mt-10">Вакансії в цій категорії</h2>
        @if($jobs->count())
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($jobs as $job)
                    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-700 dark:text-cyan-300 mb-1">{{ $job->title }}</h3>
                        <div class="text-gray-600 dark:text-gray-200 mb-2">{{ $job->location }}</div>
                        <div class="text-gray-500 dark:text-gray-400 text-sm mb-3">{{ \Illuminate\Support\Str::limit($job->description, 80) }}</div>
                        <div class="mt-auto flex justify-between items-center">
                            <span class="text-cyan-700 dark:text-cyan-400 font-bold">{{ number_format($job->salary_min) }}–{{ number_format($job->salary_max) }} грн</span>
                            <a href="{{ route('jobs.public.show', $job) }}" class="btn btn-primary action-btn">Детальніше</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 dark:text-gray-400">Вакансій у цій категорії поки немає.</div>
        @endif
    @endif

    {{-- Послуги (гості, роботодавці, адмін) --}}
    @if(!$user || $isEmployer || $isAdmin)
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4 mt-10">Послуги в цій категорії</h2>
        @if($services->count())
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($services as $service)
                    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-700 dark:text-cyan-300 mb-1">{{ $service->name }}</h3>
                        <div class="text-gray-600 dark:text-gray-200 mb-2">{{ $service->description }}</div>
                        <div class="mt-auto flex justify-between items-center">
                            <span class="text-cyan-700 dark:text-cyan-400 font-bold">{{ number_format($service->price) }} грн/м²</span>
                            <a href="{{ route('services.public.show', $service) }}" class="btn btn-primary action-btn">Детальніше</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 dark:text-gray-400">Послуг у цій категорії поки немає.</div>
        @endif
    @endif
</div>
@endsection
