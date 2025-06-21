@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-cyan-700 dark:text-cyan-300 mb-6">Вакансії</h1>

        <!-- Фільтри -->
        <form method="GET" action="{{ route('jobs.public.index') }}" class="bg-gray-50 dark:bg-gray-900 rounded shadow px-4 py-4 mb-8 flex flex-col md:flex-row gap-4 items-end">
            <div class="flex flex-col">
                <label for="category" class="text-gray-700 dark:text-gray-300 font-medium mb-1">Категорія</label>
                <select name="category" id="category" class="form-control bg-gray-800 text-gray-200">
                    <option value="">Усі категорії</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label for="skill" class="text-gray-700 dark:text-gray-300 font-medium mb-1">Навичка</label>
                <select name="skill" id="skill" class="form-control bg-gray-800 text-gray-200">
                    <option value="">Усі навички</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}" @selected(request('skill') == $skill->id)>{{ $skill->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1">
                <label for="search" class="text-gray-700 dark:text-gray-300 font-medium mb-1">Пошук</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Назва чи опис..."
                    class="form-control bg-gray-800 text-gray-200" />
            </div>
            <div >
                <button type="submit" class="btn btn-success mt-4 md:mt-0 action-btn">Застосувати</button>
                <a href="{{ route('jobs.public.index') }}" class="btn btn-secondary mt-2 md:mt-0 ml-2 action-btn">Скинути</a>
            </div>
        </form>

        <!-- Список вакансій -->
        @if($jobs->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 flex flex-col h-full">
                        <div class="flex items-center mb-2">
                            <h2 class="text-xl font-bold text-cyan-700 dark:text-cyan-200 flex-1">
                                <a href="{{ route('jobs.public.show', $job->id) }}" class="hover:underline">
                                    {{ $job->title }}
                                </a>
                            </h2>
                            <span class="badge bg-info text-gray-700 dark:text-gray-200 ml-2">
                                {{ $job->category->name ?? 'Категорія' }}
                            </span>
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 mb-2 flex-1">
                            {{ Str::limit($job->description, 120) }}
                        </div>
                        @if($job->skills && $job->skills->count())
                            <div class="mb-2">
                                <span class="font-semibold text-gray-600 dark:text-gray-300">Навички:</span>
                                @foreach($job->skills as $skill)
                                    <span class="badge bg-blue-600 text-white">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex flex-wrap gap-2 mb-2">
                            <span class="text-sm text-gray-500">
                                Зарплата: <span class="font-bold text-cyan-700 dark:text-cyan-300">{{ $job->salary_min }}&ndash;{{ $job->salary_max }} грн</span>
                            </span>
                            <span class="text-sm text-gray-400">Локація: {{ $job->location }}</span>
                        </div>
                        <div class="flex justify-between items-end">
                            <span class="text-sm text-gray-500">Додано: {{ $job->created_at->format('d.m.Y') }}</span>
                            <a href="{{ route('jobs.public.show', $job->id) }}" class="btn btn-primary action-btn">
                                Детальніше
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $jobs->links() }}
            </div>
        @else
            <div class="text-gray-500 dark:text-gray-400">Вакансій за заданими критеріями не знайдено.</div>
        @endif
    </div>
</div>
@endsection
