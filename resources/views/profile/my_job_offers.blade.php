@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Мої пропозиції</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if(isset($myJobOffers) && $myJobOffers->count())
            <div class="overflow-x-auto">
                <table class="table table-hover table-styled w-full">
                    <thead>
                        <tr>
                            <th>Вакансія</th>
                            <th>Категорія</th>
                            <th>Працівник</th>
                            <th>Статус</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myJobOffers as $offer)
                            <tr>
                                <td class="text-gray-700">
                                    {{ $offer->job->title ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $offer->job->category->name ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $offer->user->name ?? '—' }}
                                </td>
                                <td>
                                    @php
                                        $status = $offer->status ?? 'pending';
                                        $statusText = [
                                            'pending' => 'Очікує',
                                            'approved' => 'Підтверджено',
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
                                    {{ $offer->created_at ? $offer->created_at->format('d.m.Y H:i') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-gray-400">У вас поки немає створених пропозицій.</div>
        @endif
    </div>
</div>
@endsection
