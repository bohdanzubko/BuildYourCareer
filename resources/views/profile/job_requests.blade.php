@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Мої заявки на вакансії</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if(isset($jobRequests) && $jobRequests->count())
            <div class="overflow-x-auto">
                <table class="table table-hover table-styled w-full">
                    <thead>
                        <tr>
                            <th>Вакансія</th>
                            <th>Категорія</th>
                            <th>Роботодавець</th>
                            <th>Статус заявки</th>
                            <th>Дата подачі</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobRequests as $request)
                            <tr>
                                <td class="text-gray-700">
                                    {{ $request->job->title ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->job->category->name ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->job->employer->name ?? '—' }}
                                </td>
                                <td>
                                    @php
                                        $status = $request->status ?? 'pending';
                                        $statusText = [
                                            'pending' => 'Очікує',
                                            'approved' => 'Прийнято',
                                            'rejected' => 'Відхилено',
                                        ][$status] ?? $status;
                                        $statusClass = [
                                            'pending' => 'badge bg-warning text-dark',
                                            'approved' => 'badge bg-success text-white',
                                            'rejected' => 'badge bg-danger text-white',
                                        ][$status] ?? 'badge bg-secondary text-white';
                                    @endphp
                                    <span class="{{ $statusClass }}, text-gray-700">{{ $statusText }}</span>
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->created_at ? $request->created_at->format('d.m.Y H:i') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-gray-400">Ви ще не подали жодної заявки.</div>
        @endif
    </div>
</div>
@endsection
