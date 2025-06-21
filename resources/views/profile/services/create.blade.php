@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Додати послугу</h1>

    @include('profile.partials.menu')

    <form action="{{ route('profile.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-[#23272f] rounded shadow p-6 max-w-lg mx-auto">
        @csrf

        <!-- Назва послуги -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="name">Назва послуги</label>
            <input type="text" name="name" id="name"
                   class="form-control bg-gray-800 text-gray-200 @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required>
            @error('name')
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
            <label class="block text-gray-300 font-medium mb-1" for="description">Опис послуги</label>
            <textarea name="description" id="description"
                      class="form-control bg-gray-800 text-gray-200 @error('description') is-invalid @enderror"
                      rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <!-- Ціна за одиницю -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="price">Ціна (за 1 м² або іншу одиницю)</label>
            <input type="number" name="price" id="price"
                   class="form-control bg-gray-800 text-gray-200 @error('price') is-invalid @enderror"
                   min="0" step="0.01" value="{{ old('price') }}" required>
            @error('price')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <!-- Навички (мультиселект) -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="skills">Необхідні навички</label>
            <select name="skills[]" id="skills" multiple
                    class="form-control bg-gray-800 text-gray-200 @error('skills') is-invalid @enderror">
                @foreach($skills as $skill)
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

        <!-- Теги (input із комами) -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="tags">Теги (через кому)</label>
            <input type="text" name="tags" id="tags"
                   class="form-control bg-gray-800 text-gray-200 @error('tags') is-invalid @enderror"
                   value="{{ old('tags') }}">
            <small class="text-gray-400">Введіть ключові слова, розділені комою (наприклад: плитка, ремонт, швидко)</small>
            @error('tags')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <!-- Прикріплення файлу (опціонально) -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-1" for="file">Прикріпити файл (опціонально)</label>
            <input type="file" name="file" id="file"
                   class="form-control bg-gray-800 text-gray-200 @error('file') is-invalid @enderror">
            @error('file')
                <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn btn-success action-btn">Створити послугу</button>
        </div>
    </form>
</div>
@endsection
