@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Відгуки про мене</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if(isset($feedbacks) && $feedbacks->count())
            <div class="space-y-4">
                @foreach($feedbacks as $feedback)
                    <div class="border-b border-gray-700 pb-3 mb-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-gray-100">
                                {{ $feedback->user->name ?? 'Гість' }}
                                <span class="ml-2 text-xs text-gray-400">
                                    ({{ $feedback->created_at ? $feedback->created_at->format('d.m.Y') : '-' }})
                                </span>
                            </span>
                            <span>
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill text-yellow-400' : '' }}"></i>
                                @endfor
                                <span class="ml-2 text-sm text-gray-400">({{ $feedback->rating }})</span>
                            </span>
                        </div>
                        <div class="mb-1 text-gray-300">
                            <span class="font-semibold text-gray-400">Вакансія:</span>
                            {{ $feedback->job->title ?? '—' }}
                        </div>
                        <div class="mb-1 text-gray-200">{{ $feedback->comment }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-400">Поки що немає жодного відгуку про вас.</div>
        @endif
    </div>
</div>
@endsection
