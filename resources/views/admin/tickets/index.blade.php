@extends('layouts.admin')

@section('title', 'Заявки')

@section('content')
    <div class="page-header">
        <h1>Заявки</h1>
        <p>Список всех заявок</p>
    </div>

    <div class="card" style="margin-bottom: 16px;">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="filter-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Email</label>
                    <input type="text" name="email" value="{{ $filters['email'] ?? '' }}" placeholder="Email клиента...">
                </div>
                <div class="filter-group">
                    <label>Телефон</label>
                    <input type="text" name="phone" value="{{ $filters['phone'] ?? '' }}" placeholder="Телефон клиента...">
                </div>
                <div class="filter-group">
                    <label>Статус</label>
                    <select name="status">
                        <option value="">Все</option>
                        <option value="new" {{ ($filters['status'] ?? '') === 'new' ? 'selected' : '' }}>Новый</option>
                        <option value="on_process" {{ ($filters['status'] ?? '') === 'on_process' ? 'selected' : '' }}>В работе</option>
                        <option value="done" {{ ($filters['status'] ?? '') === 'done' ? 'selected' : '' }}>Обработан</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Дата от</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="filter-group">
                    <label>Дата до</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Найти</button>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm" style="background: #f1f5f9; color: #475569;">Сбросить</a>
                </div>
            </div>
        </form>
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
