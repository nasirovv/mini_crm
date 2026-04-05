@extends('layouts.admin')

@section('title', $customer->name)

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('admin.customers.index') }}" class="btn btn-sm" style="background: #f1f5f9; color: #475569;">← Назад</a>
            <h1>{{ $customer->name }}</h1>
        </div>
    </div>

    <div class="card" style="margin-bottom: 16px;">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Информация</h2>
        <table>
            <tbody>
            <tr>
                <td style="font-weight: 500; width: 200px;">Имя</td>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Email</td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Телефон</td>
                <td>{{ $customer->phone }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Количество заявок</td>
                <td>{{ $customer->tickets_count }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Дата регистрации</td>
                <td>{{ $customer->created_at->format('d.m.Y H:i') }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Заявки клиента</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Тема</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($customer->tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
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
                        <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Заявок нет
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
