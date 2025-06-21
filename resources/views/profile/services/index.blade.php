@extends('layouts.app')

@section('content')
@php
    $isOwner = auth()->check() && auth()->id() === $user->id;
    $isAdminOwner = auth()->check() && auth()->user()->role === 'admin' && auth()->id() === $user->id;
@endphp

<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Мої послуги</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if($isOwner || $isAdminOwner)
            <div class="mb-4 text-end">
                <a href="{{ route('profile.services.create') }}" class="btn btn-success action-btn">
                    <i class="bi bi-plus-circle"></i> Додати послугу
                </a>
            </div>
        @endif

        @if(isset($services) && $services->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($services as $service)
                    <div class="bg-gray-800 p-4 rounded shadow flex flex-col h-full">
                        <div class="flex items-center mb-2">
                            <h3 class="text-lg font-bold text-gray-200 flex-1">{{ $service->name }}</h3>
                            <span class="badge bg-info text-gray-300 ml-2">{{ $service->category->name ?? 'Категорія' }}</span>
                        </div>
                        <div class="text-gray-300 mb-2 flex-1">{{ $service->description }}</div>
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
                        <div class="mt-2 text-sm text-gray-400">Ціна: {{ $service->price }} грн/м²</div>
                        <div class="flex justify-end gap-2 mt-2">
                            @if($isOwner || $isAdminOwner)
                                <a href="{{ route('profile.services.edit', $service->id) }}" class="btn btn-primary action-btn">
                                    <i class="bi bi-pencil-square"></i> Редагувати
                                </a>
                                <form action="{{ route('profile.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Видалити цю послугу?')">
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
            <div class="text-gray-400">Ви ще не створили жодної послуги.</div>
        @endif
    </div>
</div>
@endsection
