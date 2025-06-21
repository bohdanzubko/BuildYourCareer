@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Пропозиції для мене</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if(isset($jobOffers) && $jobOffers->count())
            <div class="overflow-x-auto">
                <table class="table table-hover table-styled w-full">
                    <thead>
                        <tr>
                            <th>Вакансія</th>
                            <th>Категорія</th>
                            <th>Роботодавець</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th class="text-center">Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobOffers as $offer)
                            <tr>
                                <td class="text-gray-700">
                                    {{ $offer->job->title ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $offer->job->category->name ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $offer->job->employer->name ?? '—' }}
                                </td>
                                <td>
                                    @php
                                        $status = $offer->status ?? 'pending';
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
                                    {{ $offer->created_at ? $offer->created_at->format('d.m.Y H:i') : '—' }}
                                </td>
                                <td class="text-center">
                                    @if($status === 'pending')
                                        <form action="{{ route('job_offers.confirm', $offer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" name="action" value="accept" class="btn btn-success action-btn" onclick="return confirm('Підтвердити цю пропозицію?')">
                                                <i class="bi bi-check"></i> Підтвердити
                                            </button>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger action-btn ms-2" onclick="return confirm('Відхилити цю пропозицію?')">
                                                <i class="bi bi-x"></i> Відхилити
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-gray-400">Вам ще не надходили пропозиції.</div>
        @endif
    </div>
</div>
@endsection
