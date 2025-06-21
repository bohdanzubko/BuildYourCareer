@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Рекомендовані вакансії</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if(isset($suggestions) && $suggestions->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($suggestions as $job)
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
                        <div class="mt-2 text-sm text-gray-400">Зарплата: {{ $job->salary_min }}&nbsp;&ndash;&nbsp;{{ $job->salary_max }} грн/місяць</div>
                        <div class="mt-2 text-sm text-gray-400">
                            <span class="font-semibold">Роботодавець:</span>
                            {{ $job->employer->name ?? '—' }}
                        </div>
                        <div class="flex justify-end gap-2 mt-2">
                            <a href="{{ route('profile.public', $job->employer->id ?? 0) }}" class="btn btn-outline-light action-btn">
                                <i class="bi bi-person"></i> Профіль роботодавця
                            </a>
                            {{-- Додати кнопку "Подати заявку", якщо потрібно --}}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-400">Відповідних вакансій наразі не знайдено.</div>
        @endif
    </div>
</div>
@endsection
