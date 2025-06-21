@extends('layouts.app')

@section('content')

@php
    $user = auth()->user();
    $isEmployer = $user && $user->role === 'employer';
    $isWorker = $user && $user->role === 'worker';
    $isAdmin = $user && $user->role === 'admin';
@endphp

<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-center text-gray-900 dark:text-gray-100">
                <h1 class="text-3xl font-bold mb-4">Ласкаво просимо до BuildYourCareer!</h1>
                <p class="mb-4">Знаходьте роботу та послуги у будівельній сфері. Відкрийте для себе найкращі пропозиції, категорії та надійних спеціалістів.</p>
                <div class="mt-8 flex justify-center gap-4">
					@if(!$user || $isWorker || $isAdmin)
                    <a href="{{ route('jobs.public.index') }}" class="btn btn-primary action-btn">Переглянути вакансії</a>
                    @endif
					@if(!$user || $isEmployer || $isAdmin)
                    <a href="{{ route('services.public.index') }}" class="btn btn-primary action-btn">Переглянути послуги</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
