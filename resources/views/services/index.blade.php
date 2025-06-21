@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-cyan-700 dark:text-cyan-300">Каталог послуг</h1>
            <p class="text-gray-500 dark:text-gray-300 mt-2">
                Перегляньте послуги, що доступні на платформі. Використовуйте фільтри для точного пошуку.
            </p>
        </div>
        <!-- Фільтри -->
        <form method="GET" class="flex flex-wrap items-end gap-2">
            <!-- Категорія -->
            <div>
                <label for="category" class="text-gray-700 dark:text-gray-200 font-medium">Категорія</label>
                <select name="category" id="category"
                        class="form-select bg-gray-800 text-gray-100 border-gray-700 rounded">
                    <option value="">Усі</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @if(request('category') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Навичка -->
            <div>
                <label for="skill" class="text-gray-700 dark:text-gray-200 font-medium">Навичка</label>
                <select name="skill" id="skill"
                        class="form-select bg-gray-800 text-gray-100 border-gray-700 rounded">
                    <option value="">Усі</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}"
                            @if(request('skill') == $skill->id) selected @endif>
                            {{ $skill->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Тег -->
            <div>
                <label for="tag" class="text-gray-700 dark:text-gray-200 font-medium">Тег</label>
                <input type="text" name="tag" id="tag"
                    value="{{ request('tag') }}"
                    class="form-input bg-gray-800 text-gray-100 border-gray-700 rounded"
                    placeholder="Напр. ремонт">
            </div>
            <!-- Пошук -->
            <div>
                <label for="search" class="text-gray-700 dark:text-gray-200 font-medium">Пошук</label>
                <input type="text" name="search" id="search"
                    value="{{ request('search') }}"
                    class="form-input bg-gray-800 text-gray-100 border-gray-700 rounded"
                    placeholder="Ім'я чи опис">
            </div>
            <button type="submit" class="btn btn-primary h-10 action-btn">Фільтрувати</button>
            @if(request()->hasAny(['category','skill','tag','search']))
                <a href="{{ route('services.public.index') }}" class="btn btn-outline-secondary h-10 action-btn">Скинути</a>
            @endif
        </form>
    </div>

    {{-- Якщо фільтр за тегом активний, показати badge --}}
    @if(request('tag'))
        <div class="mb-2">
            <span class="inline-block bg-cyan-800 text-cyan-100 px-3 py-1 rounded-full text-sm">
                Тег: {{ request('tag') }}
                <a href="{{ request()->fullUrlWithQuery(['tag' => null]) }}" class="ml-2 text-red-300 hover:text-red-600 font-bold" title="Скинути тег">&times;</a>
            </span>
        </div>
    @endif

    @if($services->count())
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($services as $service)
                <div class="bg-white dark:bg-gray-800 rounded shadow p-5 flex flex-col h-full">
                    <div class="flex items-center mb-1">
                        <h3 class="text-lg font-bold text-gray-700 dark:text-cyan-300 flex-1">{{ $service->name }}</h3>
                        <span class="badge bg-info text-gray-300 ml-2">
                            {{ $service->category->name ?? 'Категорія' }}
                        </span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-200 mb-2 flex-1">
                        {{ \Illuminate\Support\Str::limit($service->description, 100) }}
                    </div>
                    @if($service->skills && $service->skills->count())
                        <div class="mb-2">
                            <span class="font-semibold text-gray-400">Навички:</span>
                            @foreach($service->skills as $skill)
                                <span class="badge bg-blue-600 text-white">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($service->tags && $service->tags->count())
                        <div class="mb-2">
                            <span class="font-semibold text-gray-400">Теги:</span>
                            @foreach($service->tags as $tag)
                                <span class="badge bg-cyan-800 text-cyan-100">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-2 text-sm text-gray-400">
                        Ціна: {{ $service->price }} грн/м²
                    </div>
                    <div class="flex justify-end gap-2 mt-2">
                        <a href="{{ route('services.public.show', $service->id) }}" class="btn btn-primary action-btn">
                            <i class="bi bi-eye"></i> Переглянути
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $services->withQueryString()->links() }}
        </div>
    @else
        <div class="text-gray-500 dark:text-gray-400">Немає послуг за вибраними параметрами.</div>
    @endif
</div>
@endsection
