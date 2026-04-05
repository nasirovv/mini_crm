<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Виджет обратной связи</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/widget.css') }}">
</head>
<body>

<div class="widget-container">
    <div class="widget-header">
        <div class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
            </svg>
        </div>
        <h1>Чем можем помочь?</h1>
        <p>Заполните форму ниже...</p>
    </div>

    <div class="widget-card">
        <!-- Error Alert -->
        <div class="alert alert-error" id="alertError">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            <span id="alertErrorText">Произошла ошибка. Попробуйте ещё раз.</span>
        </div>

        <!-- Form -->
        <div id="formState">
            <div class="form-row">
                <div class="form-group" id="group-name">
                    <label>Ваше полное имя <span class="required">*</span></label>
                    <input type="text" id="name" placeholder="Иван Иванов">
                    <div class="error-text" id="error-name"></div>
                </div>
                <div class="form-group" id="group-phone">
                    <label>Телефон <span class="required">*</span></label>
                    <input type="tel" id="phone" placeholder="+998901234567">
                    <div class="error-text" id="error-phone"></div>
                </div>
            </div>

            <div class="form-group" id="group-email">
                <label>Эл. почта <span class="required">*</span></label>
                <input type="email" id="email" placeholder="me@example.com">
                <div class="error-text" id="error-email"></div>
            </div>

            <div class="form-group" id="group-topic">
                <label>Тема <span class="required">*</span></label>
                <input type="text" id="topic" placeholder="О чём ваше обращение?">
                <div class="error-text" id="error-topic"></div>
            </div>

            <div class="form-group" id="group-description">
                <label>Описание <span class="required">*</span></label>
                <textarea id="description" placeholder="Подробно опишите ваш вопрос или проблему..."></textarea>
                <div class="error-text" id="error-description"></div>
            </div>

            <div class="form-group">
                <label>Прикрепить файлы</label>
                <div class="file-upload-area" id="dropZone">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                    </svg>
                    <p><span>Нажмите для загрузки</span> или перетащите файл</p>
                    <input type="file" id="files" multiple>
                </div>
                <div class="file-list" id="fileList"></div>
            </div>

            <button type="button" class="btn-submit" id="btnSubmit">
                <span class="btn-text">Отправить заявку</span>
                <div class="spinner"></div>
            </button>
        </div>

        <!-- Success State -->
        <div class="success-state" id="successState">
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <h2>Заявка отправлена!</h2>
            <p>Спасибо за ваше обращение...</p>
            <button type="button" class="btn-new-ticket" id="btnNewTicket">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Отправить ещё одну заявку
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/widget.js') }}"></script>

</body>
</html>
