@extends('layouts.app')

@section('content')
<div class="container py-10">
    <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-8">Категорії</h1>

    @if($categories->count())
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($categories as $category)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-cyan-700 dark:text-cyan-300 mb-2">{{ $category->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $category->description }}</p>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <a href="{{ route('categories.public.show', $category) }}"
                           class="btn btn-primary action-btn">
                            Переглянути
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-500 dark:text-gray-400">
            Категорій поки що немає.
        </div>
    @endif
</div>
@endsection
