@extends('layouts.admin')

@section('title', 'Заявка #' . $ticket->id)

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm" style="background: #f1f5f9; color: #475569;">← Назад</a>
            <h1>Заявка #{{ $ticket->id }}</h1>
        </div>
    </div>

    <div class="card" style="margin-bottom: 16px;">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Информация</h2>
        <table>
            <tbody>
            <tr>
                <td style="font-weight: 500; width: 200px;">Тема</td>
                <td>{{ $ticket->topic }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Статус</td>
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
            </tr>
            <tr>
                <td style="font-weight: 500;">Описание</td>
                <td>{{ $ticket->description }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Дата создания</td>
                <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Ответил</td>
                <td>{{ $ticket->answeredBy?->name ?? '—' }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Дата ответа</td>
                <td>{{ $ticket->answered_date ? \Carbon\Carbon::parse($ticket->answered_date)->format('d.m.Y H:i') : '—' }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="card" style="margin-bottom: 16px;">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Клиент</h2>
        <table>
            <tbody>
            <tr>
                <td style="font-weight: 500; width: 200px;">Имя</td>
                <td>
                    <a href="{{ route('admin.customers.show', $ticket->customer) }}">{{ $ticket->customer->name }}</a>
                </td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Email</td>
                <td>{{ $ticket->customer->email }}</td>
            </tr>
            <tr>
                <td style="font-weight: 500;">Телефон</td>
                <td>{{ $ticket->customer->phone }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    @if ($ticket->getMedia()->count())
        <div class="card">
            <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Вложения</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                @foreach ($ticket->getMedia() as $media)
                    <a href="{{ $media->getUrl() }}" target="_blank" class="btn btn-sm" style="background: #f1f5f9; color: #475569;">
                        {{ $media->file_name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection
