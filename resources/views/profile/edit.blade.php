@extends('layouts.app')

@section('content')
@php
    $isOwner = auth()->check() && auth()->id() === $user->id;
    $isAdminOwner = auth()->check() && auth()->user()->role === 'admin' && auth()->id() === $user->id;
@endphp

<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Редагування профілю</h1>

    @include('profile.partials.menu')

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-[#23272f] rounded shadow p-6">
        @csrf

        <!-- Ім'я користувача (read-only) -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1">Ім'я користувача</label>
            <input type="text" class="form-control bg-gray-800 text-gray-200" value="{{ $user->name }}" disabled>
        </div>

        <!-- Email (read-only) -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1">Email</label>
            <input type="email" class="form-control bg-gray-800 text-gray-200" value="{{ $user->email }}" disabled>
        </div>

        <!-- Телефон -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1">Телефон</label>
            <input type="text" name="phone" class="form-control bg-gray-800 text-gray-200" value="{{ old('phone', $profile->phone ?? '') }}">
        </div>

        <!-- Локація -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1">Локація</label>
            <input type="text" name="location" class="form-control bg-gray-800 text-gray-200" value="{{ old('location', $profile->location ?? '') }}">
        </div>

        <!-- Сайт -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1">Веб-сайт</label>
            <input type="url" name="website" class="form-control bg-gray-800 text-gray-200" value="{{ old('website', $profile->website ?? '') }}">
        </div>

        <!-- Блок компанії (для роботодавця або адміна у своєму профілі) -->
        @if($user->role === 'employer' || $isAdminOwner)
            <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-1">Назва компанії</label>
                <input type="text" name="company_name" class="form-control bg-gray-800 text-gray-200" value="{{ old('company_name', $profile->company_name ?? '') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-1">Опис компанії</label>
                <textarea name="company_description" class="form-control bg-gray-800 text-gray-200">{{ old('company_description', $profile->company_description ?? '') }}</textarea>
            </div>
        @endif

        <!-- Блок "Про себе" (для робітника або адміна у своєму профілі) -->
        @if($user->role === 'worker' || $isAdminOwner)
            <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-1">Біографія (про себе)</label>
                <textarea name="bio" class="form-control bg-gray-800 text-gray-200">{{ old('bio', $profile->bio ?? '') }}</textarea>
            </div>
        @endif

        <!-- Аватар -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1">Фото профілю (аватар)</label>
            <input type="file" name="avatar" class="form-control bg-gray-800 text-gray-200">
            @if($profile && $profile->avatar_url)
                <img src="{{ asset('storage/'.$profile->avatar_url) }}" alt="avatar" class="rounded mt-2" width="80">
            @endif
        </div>

        <!-- Навички (мультиселект або список, placeholder для реального інтерактиву) -->
        @if($user->role === 'worker' || $isAdminOwner)
            <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-1">Навички</label>
                <select name="skills[]" class="form-control bg-gray-800 text-gray-200" multiple>
                    @foreach($allSkills as $skill)
                        <option value="{{ $skill->id }}"
                            @if(in_array($skill->id, old('skills', $userSkills))) selected @endif>
                            {{ $skill->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-gray-400">Утримуйте Ctrl (Cmd), щоб вибрати декілька</small>
            </div>
        @endif

        <!-- Портфоліо (заглушка, інтерактив реалізується окремо) -->
        @if($user->role === 'worker' || $isAdminOwner)
            <div class="mb-4">
                <label class="block text-gray-300 font-medium mb-1">Портфоліо</label>
                <p class="text-gray-400">Завантаження портфоліо буде доступне у наступній версії.</p>
            </div>
        @endif

        <button type="submit" class="btn btn-primary mt-2 action-btn">Зберегти зміни</button>
    </form>
</div>
@endsection
