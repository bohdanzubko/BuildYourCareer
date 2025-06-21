@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-cyan-700 dark:text-cyan-300 mb-1">{{ $job->title }}</h1>
                <div class="text-gray-500 dark:text-gray-400 mb-2">
                    <span class="mr-3">
                        <i class="bi bi-briefcase"></i> Категорія: <span class="font-semibold">{{ $job->category->name ?? 'N/A' }}</span>
                    </span>
                    <span>
                        <i class="bi bi-geo-alt"></i> Локація: <span class="font-semibold">{{ $job->location }}</span>
                    </span>
                </div>
            </div>
            <div class="mt-2 md:mt-0">
                <span class="inline-block px-3 py-1 rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-100 font-semibold text-sm">
                    {{ $job->salary_min }}&ndash;{{ $job->salary_max }} грн
                </span>
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div class="mt-4 text-gray-800 dark:text-gray-100">
                {!! nl2br(e($job->description)) !!}
            </div>
            @auth
                @if(auth()->user()->role === 'worker')
                    @if(!$alreadyRequested)
                        <form action="{{ route('job_requests.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ $job->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-primary action-btn">Подати заявку</button>
                        </form>
                    @else
                        <div class="mb-4 text-cyan-700 font-semibold">Ви вже подали заявку на цю вакансію.</div>
                    @endif
                @endif
            @endauth
        </div>

        @if($job->skills && $job->skills->count())
            <div class="mt-3">
                <span class="font-semibold text-gray-700 dark:text-gray-300">Необхідні навички:</span>
                @foreach($job->skills as $skill)
                    <span class="badge bg-blue-600 text-white">{{ $skill->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="mt-6 mb-2 border-t pt-4 flex items-center justify-between">
            <div>
                <span class="font-medium text-gray-600 dark:text-gray-400">Роботодавець:</span>
                <span class="text-gray-800 dark:text-gray-100 font-bold">{{ $job->employer->name ?? 'N/A' }}</span>
            </div>
            <span class="text-sm text-gray-500">Додано: {{ $job->created_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>

    {{-- Блок відгуків --}}
    <div class="max-w-4xl mx-auto mt-8 bg-gray-50 dark:bg-gray-900 rounded shadow p-6">
        <h2 class="text-xl font-bold text-cyan-700 dark:text-cyan-300 mb-3">Відгуки до цієї вакансії</h2>

        {{-- Форма для залишення відгуку (тільки для робітника) --}}
        @auth
            @if(auth()->user()->role === 'worker')
                @if($isConfirmed)
                    <form action="{{ route('feedback.store') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="mb-2">
                            <label for="rating" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Оцінка</label>
                            <select name="rating" id="rating" class="form-control bg-gray-800 text-gray-200 w-32" required>
                                <option value="">Оберіть</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="comment" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Коментар</label>
                            <textarea name="comment" id="comment" class="form-control bg-gray-800 text-gray-200" rows="3" required>{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success action-btn">Залишити відгук</button>
                    </form>
                @else
                    <div class="mb-4 text-gray-400">
                        Ви зможете залишити відгук після підтвердження на цю вакансію роботодавцем.
                    </div>
                @endif
            @endif
        @endauth
        @guest
            <div class="mb-4 text-gray-400">Щоб залишити відгук, <a href="{{ route('login') }}" class="text-cyan-600 underline">увійдіть</a> як робітник.</div>
        @endguest

        {{-- Відображення відгуків --}}
        @if($job->feedbacks && $job->feedbacks->count())
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($job->feedbacks as $feedback)
                    <div class="py-4">
                        <div class="flex items-center mb-1">
                            <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $feedback->user->name ?? 'Анонім' }}</span>
                            <span class="ml-4 text-sm text-gray-500">{{ $feedback->created_at->format('d.m.Y H:i') }}</span>
                            <span class="ml-4 badge bg-yellow-400 text-yellow-900 font-bold">{{ $feedback->rating }} ★</span>
                        </div>
                        <div class="text-gray-800 dark:text-gray-100">{{ $feedback->comment }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 dark:text-gray-400">Поки що відгуків до цієї вакансії немає.</div>
        @endif
    </div>
</div>
@endsection
