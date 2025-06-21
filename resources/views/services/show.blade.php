@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-cyan-700 dark:text-cyan-300 mb-2">
                    {{ $service->name }}
                </h1>
                <div class="flex gap-2 items-center mb-2">
                    <span class="badge bg-info text-gray-700 dark:text-gray-200">
                        {{ $service->category->name ?? 'Без категорії' }}
                    </span>
                    <span class="text-gray-400 text-sm">
                        Оновлено: {{ $service->updated_at->format('d.m.Y H:i') }}
                    </span>
                </div>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary text-gray-200 action-btn">
                ← Назад до каталогу
            </a>
        </div>

        <div class="mb-6 text-lg text-gray-800 dark:text-gray-100">
            {!! nl2br(e($service->description)) !!}
        </div>

        <div class="flex flex-wrap gap-4 mb-6">
            <div>
                <span class="font-semibold text-gray-600 dark:text-gray-300">Ціна:</span>
                <span class="text-cyan-700 dark:text-cyan-300 font-bold">{{ $service->price }} грн/м²</span>
            </div>
            @if($service->skills->count())
                <div>
                    <span class="font-semibold text-gray-600 dark:text-gray-300">Навички:</span>
                    @foreach($service->skills as $skill)
                        <span class="badge bg-blue-600 text-white">{{ $skill->name }}</span>
                    @endforeach
                </div>
            @endif
            @if($service->tags->count())
                <div>
                    <span class="font-semibold text-gray-600 dark:text-gray-300">Теги:</span>
                    @foreach($service->tags as $tag)
                        <span class="badge bg-cyan-800 text-cyan-100">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
        @auth
            @if(auth()->user()->role === 'employer')
                @if(empty($alreadyRequested) || !$alreadyRequested)
                    <form action="{{ route('service-requests.store') }}" method="POST" class="mb-4 max-w-lg bg-gray-100 dark:bg-gray-900 p-4 rounded shadow">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="status" value="pending">

                        <div class="mb-3">
                            <label for="description" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Опис заявки</label>
                            <textarea name="description" id="description" rows="3" required
                                    class="form-control bg-gray-800 text-gray-200 w-full @error('description') is-invalid @enderror"
                                    placeholder="Опишіть, які саме роботи вас цікавлять...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="area" class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Площа робіт (м²)</label>
                            <input type="number" min="0" step="0.01" name="area" id="area" required
                                class="form-control bg-gray-800 text-gray-200 w-full @error('area') is-invalid @enderror"
                                value="{{ old('area') }}">
                        </div>

                        <button type="submit" class="btn btn-primary action-btn">Подати заявку</button>
                    </form>
                @else
                    <div class="mb-4 text-cyan-700 font-semibold">Ви вже подали заявку на цю послугу.</div>
                @endif
            @endif
        @else
            <div class="mb-4 text-cyan-700 font-semibold">
                Щоб подати заявку, <a href="{{ route('login') }}" class="text-cyan-600 underline">увійдіть</a> як роботодавець.
            </div>
        @endauth

        @if($service->users && $service->users->count())
            <div class="mb-6">
                <span class="font-semibold text-gray-600 dark:text-gray-300">Виконавці послуги:</span>
                <ul class="list-disc list-inside">
                    @foreach($service->users as $user)
                        <li>
                            <a href="{{ route('profile.public', $user->id) }}" class="text-cyan-600 dark:text-cyan-300 hover:underline">
                                {{ $user->name }}
                            </a>
                            @if($user->profile && $user->profile->location)
                                <span class="text-gray-400">({{ $user->profile->location }})</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection
