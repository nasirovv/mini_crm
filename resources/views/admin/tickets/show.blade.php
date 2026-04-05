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

    @if ($ticket->getMedia('tickets')->count())
        <div class="card">
            <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Вложения ({{ $ticket->getMedia('tickets')->count() }})</h2>
            <div class="file-grid">
                @foreach ($ticket->getMedia('tickets') as $media)
                    <a href="{{ asset('storage/' . $media->id . '/' . $media->file_name) }}" target="_blank" class="file-card">
                        @if (Str::startsWith($media->mime_type, 'image/'))
                            <div class="file-preview">
                                <img src="{{ asset('storage/' . $media->id . '/' . $media->file_name) }}" alt="{{ $media->file_name }}">
                            </div>
                        @else
                            <div class="file-preview file-preview-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 32px; height: 32px; color: #94a3b8;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                        @endif
                        <div class="file-name">{{ $media->file_name }}</div>
                        <div class="file-size">{{ number_format($media->size / 1024, 1) }} KB</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection
