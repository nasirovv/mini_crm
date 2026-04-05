# Mini CRM

Система управления заявками с публичным виджетом обратной связи.

## Возможности

- **Публичный виджет** — встраиваемая форма обратной связи (iframe), с drag-and-drop загрузкой файлов
- **Панель администратора** — дашборд со статистикой, управление заявками и клиентами
- **Роли и права** — admin (полный доступ), manager (заявки + клиенты)
- **Управление заявками** — фильтрация, смена статуса, просмотр вложений
- **База клиентов** — поиск, связь с заявками
- **API** — приём заявок с rate-limiting (10 запросов/мин)

## Стек

- PHP 8.3+
- Laravel 13
- Spatie Media Library (вложения)
- Spatie Permission (роли и права)
- MySQL

## Установка

### 1. Клонировать репозиторий

```bash
git clone <repo-url> crm
cd crm
```

### 2. Установить зависимости

```bash
composer install
npm install
```

### 3. Настроить окружение

```bash
cp .env.example .env
php artisan key:generate
```

Отредактируйте `.env` — укажите подключение к БД:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm
DB_USERNAME=root
DB_PASSWORD=
```

Установите `APP_URL` на адрес вашего сервера (например `http://127.0.0.1:8000`).

### 4. Создать БД и запустить миграции с сидами

```bash
php artisan migrate --seed
```

### 5. Создать символическую ссылку для файлов

```bash
php artisan storage:link
```

### 6. Запустить

```bash
npm run dev
```

Это запустит параллельно: Laravel сервер, очередь, логи и Vite.

Или по отдельности:

```bash
php artisan serve
php artisan queue:listen
```

Приложение будет доступно по адресу `http://127.0.0.1:8000`.

## Тестовые пользователи

| Роль    | Email             | Пароль   |
|---------|-------------------|----------|
| Admin   | admin@gmail.com   | password |
| Manager | manager@gmail.com | password |

## Структура проекта

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── API/
│   │   │   └── TicketController.php        # Приём заявок через API
│   │   └── WEB/
│   │       ├── AuthController.php          # Логин / логаут
│   │       ├── WidgetController.php        # Публичный виджет
│   │       └── Admin/
│   │           ├── DashboardController.php # Дашборд со статистикой
│   │           ├── TicketController.php    # CRUD заявок
│   │           └── CustomerController.php  # Просмотр клиентов
│   ├── Services/
│   │   ├── API/
│   │   │   ├── TicketService.php           # Создание заявки
│   │   │   └── CustomerService.php         # Создание/поиск клиента
│   │   └── Admin/
│   │       ├── TicketService.php           # Статистика, фильтрация, статусы
│   │       └── CustomerService.php         # Список, поиск клиентов
│   ├── Middleware/
│   │   └── AllowIframeEmbedding.php        # Разрешает iframe встраивание
│   └── Requests/
│       └── StoreTicketRequest.php          # Валидация формы заявки
├── Models/
│   ├── User.php
│   ├── Customer.php                        # name, email, phone
│   └── Ticket.php                          # topic, description, status
database/
├── migrations/                             # 10 миграций
├── factories/                              # User, Customer, Ticket
└── seeders/
    ├── RoleSeeder.php                      # Роли и права
    ├── UserSeeder.php                      # Тестовые пользователи
    ├── CustomerSeeder.php                  # 30 клиентов
    └── TicketSeeder.php                    # Заявки для каждого клиента
resources/views/
├── widget.blade.php                        # Публичная форма
├── auth/login.blade.php                    # Страница входа
├── admin/
│   ├── dashboard.blade.php                 # Дашборд
│   ├── tickets/index.blade.php             # Список заявок
│   ├── tickets/show.blade.php              # Детали заявки
│   ├── customers/index.blade.php           # Список клиентов
│   └── customers/show.blade.php            # Детали клиента
└── layouts/
    ├── admin.blade.php                     # Основной layout
    └── pagination.blade.php                # Пагинация
public/
├── css/admin.css                           # Стили админки
├── css/login.css                           # Стили логина
├── css/widget.css                          # Стили виджета
├── js/admin.js                             # JS админки
└── js/widget.js                            # JS виджета
```

## Маршруты

### Публичные

| Метод | URL       | Описание             |
|-------|-----------|----------------------|
| GET   | `/widget` | Форма обратной связи |
| GET   | `/login`  | Страница входа       |
| POST  | `/login`  | Авторизация          |

### API

| Метод | URL            | Описание                    |
|-------|----------------|-----------------------------|
| POST  | `/api/tickets` | Создать заявку (10 req/min) |

### Админ-панель (требуется авторизация)

| Метод  | URL                             | Права            | Описание           |
|--------|---------------------------------|-------------------|---------------------|
| GET    | `/admin/dashboard`              | —                 | Дашборд            |
| DELETE | `/admin/logout`                 | —                 | Выход              |
| GET    | `/admin/tickets`                | manage-tickets    | Список заявок      |
| GET    | `/admin/tickets/{id}`           | manage-tickets    | Детали заявки      |
| PATCH  | `/admin/tickets/{id}/status`    | manage-tickets    | Смена статуса      |
| GET    | `/admin/customers`              | manage-customers  | Список клиентов    |
| GET    | `/admin/customers/{id}`         | manage-customers  | Детали клиента     |

## Роли и права

| Право            | admin | manager |
|------------------|-------|---------|
| manage-users     | +     | —       |
| manage-tickets   | +     | +       |
| manage-customers | +     | +       |

## Статусы заявок

| Значение     | Название  | Описание                                        |
|--------------|-----------|-------------------------------------------------|
| `new`        | Новый     | Заявка только создана                            |
| `on_process` | В работе  | Заявка взята в обработку                         |
| `done`       | Обработан | Заявка закрыта, фиксируется кто и когда ответил |

## Виджет

Виджет можно встроить на любой сайт через iframe:

```html
<iframe src="https://your-domain.com/widget" width="100%" height="600" frameborder="0"></iframe>
```

Поддерживает:
- Загрузку до 5 файлов (jpg, png, pdf, doc, docx), до 10 МБ каждый
- Drag-and-drop
- Валидацию формы на клиенте и сервере
- Формат телефона: +998XXXXXXXXX

## Валидация заявки (API)

| Поле        | Правила                                      |
|-------------|----------------------------------------------|
| name        | обязательно, строка, макс. 255               |
| email       | обязательно, email, макс. 255                |
| phone       | обязательно, формат E.164 (+998...)          |
| topic       | обязательно, строка, макс. 255               |
| description | обязательно, строка, макс. 5000              |
| files       | необязательно, массив, макс. 5 файлов        |
| files.*     | файл, макс. 10 МБ, jpg/jpeg/png/pdf/doc/docx |
