@extends('layouts.admin')

@section('title', 'Заявки')

@section('content')
    <div class="page-header">
        <h1>Заявки</h1>
        <p>Список всех заявок</p>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Тема</th>
                    <th>Статус</th>
                    <th>Ответил</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>
                            <div style="font-weight: 500;">{{ $ticket->customer->name }}</div>
                            <div style="font-size: 12px; color: #64748b;">{{ $ticket->customer->email }}</div>
                        </td>
                        <td>{{ Str::limit($ticket->topic, 40) }}</td>
                        <td>
                            @php
                                $statusLabels = [
                                    'new' => 'Новый',
                                    'on_process' => 'В работе',
                                    'done' => 'Обработан',
                                ];
                            @endphp
                            <span class="badge badge-{{ $ticket->status }}">
                                {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                            </span>
                        </td>
                        <td>{{ $ticket->answeredBy?->name ?? '—' }}</td>
                        <td style="font-size: 13px; color: #64748b;">
                            {{ $ticket->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm" style="background: #f1f5f9; color: #475569;">
                                Открыть
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Заявок пока нет
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $tickets->links('layouts.pagination') }}
        </div>
    </div>
@endsection
