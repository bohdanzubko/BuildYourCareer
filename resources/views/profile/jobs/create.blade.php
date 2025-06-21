@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Додати вакансію</h1>

    @include('profile.partials.menu')

    <form action="{{ route('profile.jobs.store') }}" method="POST" enctype="multipart/form-data" class="bg-[#23272f] rounded shadow p-6 max-w-lg mx-auto">
        @csrf

        <!-- Назва вакансії -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="title">Назва вакансії</label>
            <input type="text" name="title" id="title"
                   class="form-control bg-gray-800 text-gray-200 @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <!-- Категорія -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="category_id">Категорія</label>
            <select name="category_id" id="category_id"
                    class="form-control bg-gray-800 text-gray-200 @error('category_id') is-invalid @enderror"
                    required>
                <option value="">Оберіть категорію</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <!-- Опис -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="description">Опис вакансії</label>
            <textarea name="description" id="description"
                      class="form-control bg-gray-800 text-gray-200 @error('description') is-invalid @enderror"
                      rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <!-- Місце роботи -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="location">Місце роботи</label>
            <input type="text" name="location" id="location"
                   class="form-control bg-gray-800 text-gray-200 @error('location') is-invalid @enderror"
                   value="{{ old('location') }}" required>
            @error('location')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <!-- Зарплата -->
        <div class="mb-4 flex gap-2">
            <div class="flex-1">
                <label class="block text-gray-300 font-medium mb-1" for="salary_min">Зарплата (мін)</label>
                <input type="number" name="salary_min" id="salary_min"
                       class="form-control bg-gray-800 text-gray-200 @error('salary_min') is-invalid @enderror"
                       min="0" step="0.01" value="{{ old('salary_min') }}" required>
                @error('salary_min')
                    <div class="invalid-feedback text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex-1">
                <label class="block text-gray-300 font-medium mb-1" for="salary_max">Зарплата (макс)</label>
                <input type="number" name="salary_max" id="salary_max"
                       class="form-control bg-gray-800 text-gray-200 @error('salary_max') is-invalid @enderror"
                       min="0" step="0.01" value="{{ old('salary_max') }}" required>
                @error('salary_max')
                    <div class="invalid-feedback text-red-400">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Необхідні навички (мультиселект) -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="skills">Необхідні навички</label>
            <select name="skills[]" id="skills" multiple
                    class="form-control bg-gray-800 text-gray-200 @error('skills') is-invalid @enderror">
                @foreach($allSkills as $skill)
                    <option value="{{ $skill->id }}" @if(collect(old('skills'))->contains($skill->id)) selected @endif>
                        {{ $skill->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-gray-400">Виберіть одну або кілька навичок</small>
            @error('skills')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn btn-success action-btn">Створити вакансію</button>
        </div>
    </form>
</div>
@endsection
