@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Мій профіль</h1>

    @include('profile.menu')

    <div class="card mb-4">
        <div class="card-header">Особисті дані</div>
        <div class="card-body">
            <p><strong>Ім'я:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Категорії робіт</div>
        <div class="card-body">
            <ul>
                @foreach ($jobCategories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Основні здібності</div>
        <div class="card-body">
            <ul>
                @foreach ($skills as $skill)
                    <li>{{ $skill->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Минулі проєкти</div>
        <div class="card-body">
            <ul>
                @forelse ($confirmedJobs as $jobs)
                    <li>{{ $jobs->title }}</li>
                @empty
                    <li>Немає завершених проєктів</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection