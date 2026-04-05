<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход — CRM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h1>Вход в систему</h1>
        <p>Панель управления CRM</p>
    </div>

    <div class="login-card">
        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Эл. почта</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@crm.test" required autofocus>
            </div>

            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">Войти</button>
        </form>
    </div>
</div>
</body>
</html>
