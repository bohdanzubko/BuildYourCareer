@extends('layouts.app')

@section('content')
@php
    $isOwner = auth()->check() && auth()->id() === $user->id;
    $isAdminOwner = auth()->check() && auth()->user()->role === 'admin' && auth()->id() === $user->id;
@endphp

<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Мої вакансії</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if($isOwner || $isAdminOwner)
            <div class="mb-4 text-end">
                <a href="{{ route('profile.jobs.create') }}" class="btn btn-success action-btn">
                    <i class="bi bi-plus-circle"></i> Додати вакансію
                </a>
            </div>
        @endif

        @if(isset($jobs) && $jobs->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($jobs as $job)
                    <div class="bg-gray-800 p-4 rounded shadow flex flex-col h-full">
                        <div class="flex items-center mb-2">
                            <h3 class="text-lg font-bold text-gray-200 flex-1">{{ $job->title }}</h3>
                            <span class="badge bg-info text-gray-300 ml-2">{{ $job->category->name ?? 'Категорія' }}</span>
                        </div>
                        <div class="text-gray-300 mb-2 flex-1">{{ $job->description }}</div>
                        <div class="mb-2 text-gray-400">
                            <span class="font-semibold">Місце:</span> {{ $job->location }}
                        </div>
                        @if($job->skills && $job->skills->count())
                            <div class="mb-2">
                                <span class="font-semibold text-gray-400">Необхідні навички:</span>
                                @foreach($job->skills as $skill)
                                    <span class="badge bg-blue-600 text-white">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-2 text-sm text-gray-400">Зарплата: {{ $job->salary_min }}&nbsp;&ndash;&nbsp;{{ $job->salary_max }} грн</div>
                        <div class="flex justify-end gap-2 mt-2">
                            @if($isOwner || $isAdminOwner)
                                <a href="{{ route('profile.jobs.edit', $job->id) }}" class="btn btn-primary action-btn">
                                    <i class="bi bi-pencil-square"></i> Редагувати
                                </a>
                                <form action="{{ route('profile.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Видалити цю вакансію?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger action-btn">
                                        <i class="bi bi-trash"></i> Видалити
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-400">Ви ще не створили жодної вакансії.</div>
        @endif
    </div>
</div>
@endsection
