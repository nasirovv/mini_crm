@extends('layouts.admin')

@section('title', 'Главная')

@section('content')
    <div class="page-header">
        <h1>Главная</h1>
        <p>Обзор заявок и статистика</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Сегодня</div>
            <div class="stat-value" id="stat-today">{{ $todayCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">За неделю</div>
            <div class="stat-value" id="stat-week">{{ $weekCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">За месяц</div>
            <div class="stat-value" id="stat-month">{{ $monthCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Всего</div>
            <div class="stat-value" id="stat-total">{{ $totalCount }}</div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="font-size: 16px; font-weight: 600;">Последние заявки</h2>
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-primary btn-sm">Все заявки</a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Тема</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($recentTickets as $ticket)
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
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Заявок пока нет
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
