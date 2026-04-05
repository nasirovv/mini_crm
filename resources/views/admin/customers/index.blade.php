@extends('layouts.admin')

@section('title', 'Клиенты')

@section('content')
    <div class="page-header">
        <h1>Клиенты</h1>
        <p>Список всех клиентов</p>
    </div>

    <div class="card" style="margin-bottom: 16px;">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="filter-form">
            <div class="filter-row">
                <div class="filter-group" style="flex: 1;">
                    <label>Поиск</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Имя, email, телефон...">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Найти</button>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-sm" style="background: #f1f5f9; color: #475569;">Сбросить</a>
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
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Заявок</th>
                    <th>Дата регистрации</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>#{{ $customer->id }}</td>
                        <td style="font-weight: 500;">{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->tickets_count }}</td>
                        <td style="font-size: 13px; color: #64748b;">
                            {{ $customer->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm" style="background: #f1f5f9; color: #475569;">
                                Открыть
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                            Клиентов пока нет
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $customers->links('layouts.pagination') }}
        </div>
    </div>
@endsection
