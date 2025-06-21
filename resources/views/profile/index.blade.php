@extends('layouts.app')

@section('content')
@php
    $isOwner = auth()->check() && auth()->id() === $user->id;
    $isAdminOwner = auth()->check() && auth()->user()->role === 'admin' && auth()->id() === $user->id;
@endphp
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-800">Профіль користувача</h1>
    
    {{-- Меню профілю --}}
    @include('profile.partials.menu')

    <!-- Основна інформація -->
    <div class="bg-white rounded shadow p-4 mb-4 flex flex-col md:flex-row items-start md:items-center gap-4">
        <img src="{{ $profile && $profile->avatar_url ? asset('storage/'.$profile->avatar_url) : asset('img/default_avatar.png') }}"
             class="rounded-full w-24 h-24 object-cover border"
             alt="avatar">

        <div class="flex-1">
            <h2 class="text-xl font-bold mb-1">{{ $user->name }}</h2>
            @if ($user->role === 'employer')
                <span class="inline-block mb-2 px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Роботодавець</span>
            @elseif ($user->role === 'worker')
                <span class="inline-block mb-2 px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Робітник</span>
            @elseif ($user->role === 'admin')
                <span class="inline-block mb-2 px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Адміністратор</span>
            @endif

            @if ($profile)
                @if($profile->phone)<p class="mb-1"><i class="bi bi-telephone"></i> {{ $profile->phone }}</p>@endif
                @if($profile->location)<p class="mb-1"><i class="bi bi-geo-alt"></i> {{ $profile->location }}</p>@endif
                @if($profile->website)
                    <p class="mb-1"><i class="bi bi-globe"></i> 
                        <a href="{{ $profile->website }}" class="text-blue-600 hover:underline" target="_blank">{{ $profile->website }}</a>
                    </p>
                @endif
                @if($profile->company_name && $user->role === 'employer')
                    <p class="mb-1"><i class="bi bi-building"></i> {{ $profile->company_name }}</p>
                @endif
                @if($profile->company_description && $user->role === 'employer')
                    <p class="mb-1 text-gray-700">{{ $profile->company_description }}</p>
                @endif
                @if($profile->bio && ($user->role === 'worker' || $isAdminOwner))
                    <p class="mb-1"><span class="font-semibold">Про себе:</span> {{ $profile->bio }}</p>
                @endif
            @endif
        </div>
        <div class="flex flex-col items-center md:items-end gap-1">
            @php $rating = $profile->rating ?? 0; @endphp
            <div class="flex items-center">
                <span class="font-bold mr-1">Рейтинг:</span>
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= round($rating) ? '-fill text-yellow-400' : '' }}"></i>
                @endfor
                <span class="ml-1 text-sm text-gray-600">({{ number_format($rating, 1) }})</span>
            </div>
            <div class="text-sm text-gray-500">Відгуків: {{ $profile->reviews_count ?? 0 }}</div>
        </div>
    </div>

    {{-- Розширений профіль для робітника або для адміна у власному профілі --}}
    @if($user->role === 'worker' || $isAdminOwner)
        <!-- Категорії -->
        @if ($categories && $categories->isNotEmpty())
        <div class="bg-white rounded shadow p-4 mb-4">
            <h3 class="text-lg font-semibold mb-2">Категорії</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($categories as $category)
                    <span class="inline-block bg-gray-200 rounded px-3 py-1 text-sm">{{ $category->name }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Навички -->
        @if ($skills && $skills->isNotEmpty())
        <div class="bg-white rounded shadow p-4 mb-4">
            <h3 class="text-lg font-semibold mb-2">Навички</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($skills as $skill)
                    <span class="inline-block bg-blue-100 text-blue-800 rounded px-3 py-1 text-sm">{{ $skill->name }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Підтверджені роботи -->
        @if ($confirmedJobs && $confirmedJobs->isNotEmpty())
        <div class="bg-white rounded shadow p-4 mb-4">
            <h3 class="text-lg font-semibold mb-2">Підтверджені роботи</h3>
            <ul class="list-disc list-inside">
                @foreach ($confirmedJobs as $job)
                    <li>{{ $job->title ?? 'Job' }} 
                        @if(isset($job->created_at))
                            <span class="text-gray-400">({{ $job->created_at->format('d.m.Y') }})</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Портфоліо -->
        <div class="bg-white rounded shadow p-4 mb-4">
            <h3 class="text-lg font-semibold mb-2">Портфоліо</h3>
            @if(isset($portfolio) && count($portfolio))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($portfolio as $item)
                        <div class="border rounded overflow-hidden bg-gray-50">
                            @if($item->type === 'image')
                                <img src="{{ asset('storage/'.$item->file_path) }}" class="w-full h-40 object-cover" alt="portfolio image">
                            @else
                                <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank" class="block py-4 text-center text-blue-600 hover:underline">Переглянути файл</a>
                            @endif
                            <div class="p-2">
                                <p class="text-sm">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Портфоліо відсутнє</p>
            @endif
        </div>
    @endif

    <!-- Відгуки (для всіх) -->
    <div class="bg-white rounded shadow p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">Відгуки</h3>
        @if(isset($feedbacks) && count($feedbacks))
            @foreach($feedbacks as $review)
                <div class="border-b pb-2 mb-2">
                    <div class="font-bold">{{ $review->user->name ?? 'Гість' }}:
                        @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-yellow-400' : '' }}"></i>
                        @endfor
                        <span class="ml-2 text-sm">({{ $review->rating }})</span>
                    </div>
                    <div>{{ $review->comment }}</div>
                    <div class="text-gray-500 text-xs">{{ $review->created_at->format('d.m.Y') }}</div>
                </div>
            @endforeach
        @else
            <p class="text-gray-600">Відгуків ще немає</p>
        @endif
    </div>
</div>
@endsection
