@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-2xl font-semibold text-gray-200">Заявки на мої послуги</h1>

    @include('profile.partials.menu')

    <div class="bg-[#23272f] rounded shadow p-6">
        @if(isset($serviceRequests) && $serviceRequests->count())
            <div class="overflow-x-auto">
                <table class="table table-hover table-styled w-full">
                    <thead>
                        <tr>
                            <th>Послуга</th>
                            <th>Категорія</th>
                            <th>Клієнт</th>
                            <th>Площа (м²)</th>
                            <th>Орієнтовна ціна</th>
                            <th>Статус заявки</th>
                            <th>Дата подачі</th>
                            <th class="text-center">Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceRequests as $request)
                            <tr>
                                <td class="text-gray-700">
                                    {{ $request->service->name ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->service->category->name ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->user->name ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->area ?? '—' }}
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->estimated_price ?? '—' }}
                                </td>
                                <td>
                                    @php
                                        $status = $request->status ?? 'pending';
                                        $statusText = [
                                            'pending' => 'Очікує',
                                            'in_progress' => 'В процесі',
                                            'rejected' => 'Завершено',
                                        ][$status] ?? $status;
                                        $statusClass = [
                                            'pending' => 'badge bg-warning text-dark',
                                            'in_progress' => 'badge bg-success text-white',
                                            'rejected' => 'badge bg-danger text-white',
                                        ][$status] ?? 'badge bg-secondary text-white';
                                    @endphp
                                    <span class="{{ $statusClass }}, text-gray-700">{{ $statusText }}</span>
                                </td>
                                <td class="text-gray-700">
                                    {{ $request->created_at ? $request->created_at->format('d.m.Y H:i') : '—' }}
                                </td>
                                <td class="text-center">
                                    @if($status === 'pending')
                                        <form action="{{ route('service_requests.confirm', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" name="action" value="accept" class="btn btn-success action-btn" onclick="return confirm('Підтвердити цю заявку?')">
                                                <i class="bi bi-check"></i> Підтвердити
                                            </button>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger action-btn ms-2" onclick="return confirm('Відхилити цю заявку?')">
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
            <div class="text-gray-400">Поки що немає заявок на ваші послуги.</div>
        @endif
    </div>
</div>
@endsection
