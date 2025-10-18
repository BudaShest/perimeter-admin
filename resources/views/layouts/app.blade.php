<!DOCTYPE html>
<html lang="ru" data-bs-theme="{{ $currentTheme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Периметр')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">

    @livewireStyles

    <style>
        .navbar-brand { font-weight: bold; }
        .auth-container { max-width: 400px; margin: 100px auto; }
        .flash-message { position: fixed; top: 20px; right: 20px; z-index: 1050; }

        /* Плавные переходы для темы */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Кастомные стили для тёмной темы */
        [data-bs-theme="dark"] {
            --bs-body-color: #e0e0e0;
            --bs-body-bg: #121212;
        }

        [data-bs-theme="dark"] .card {
            background-color: #1e1e1e;
            border-color: #333;
        }

        [data-bs-theme="dark"] .navbar-dark {
            background-color: #1a1a1a !important;
        }

        /* Стили для переключателя темы */
        .theme-switcher {
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .theme-switcher:hover {
            transform: rotate(30deg);
        }

        .theme-icon {
            display: none;
        }

        [data-bs-theme="dark"] .theme-icon.moon {
            display: inline;
        }

        [data-bs-theme="light"] .theme-icon.sun {
            display: inline;
        }
    </style>
</head>
<body>
<!-- Навигация -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Периметр</a>


        <!-- Переключатель темы -->
        <button class="theme-switcher btn btn-outline-light btn-sm me-3" id="themeToggle" title="Сменить тему">
            <span class="theme-icon sun">🌙</span>
            <span class="theme-icon moon">☀️</span>
        </button>
        <div class="container">
            <div class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/department">Подразделения</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/area">Объекты</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link active" href="/dashboard">{{ Auth::user()->name }}</a>
                    </li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Выйти</button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Flash сообщения -->
@if(session('success'))
    <div class="flash-message alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="flash-message alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Основной контент -->
<main class="container py-4">
    @yield('content')
</main>
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <ul class="list-group col-3">
                <li class="list-group-item">
                    <a href="">budashest@gmail.com</a>
                </li>
                <li class="list-group-item">
                    <a href="">+7-995-472-06-14</a>
                </li>
            </ul>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;

        // Функция для применения темы
        function applyTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
        }

        // При загрузке страницы проверяем актуальную тему на сервере
        function syncThemeWithServer() {
            fetch('{{ route("theme.current") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        applyTheme(data.theme);
                    }
                })
                .catch(error => {
                    console.error('Error syncing theme:', error);
                    // В случае ошибки используем тему из localStorage
                    const savedTheme = localStorage.getItem('theme');
                    if (savedTheme) {
                        applyTheme(savedTheme);
                    }
                });
        }

        // Синхронизируем тему при загрузке страницы
        syncThemeWithServer();

        themeToggle.addEventListener('click', function() {
            // Показываем индикатор загрузки
            themeToggle.classList.add('loading');
            themeToggle.disabled = true;

            // Отправляем запрос на сервер для переключения темы
            fetch('{{ route("theme.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        applyTheme(data.theme);
                        showFlashMessage(data.message, 'success');
                    } else {
                        showFlashMessage(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showFlashMessage('Ошибка при смене темы', 'danger');
                })
                .finally(() => {
                    themeToggle.classList.remove('loading');
                    themeToggle.disabled = false;
                });
        });

        function showFlashMessage(message, type) {
            const oldMessages = document.querySelectorAll('.flash-message');
            oldMessages.forEach(msg => msg.remove());

            const flashDiv = document.createElement('div');
            flashDiv.className = `flash-message alert alert-${type} alert-dismissible fade show`;
            flashDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

            document.body.appendChild(flashDiv);

            setTimeout(() => {
                if (flashDiv.parentNode) {
                    const bsAlert = new bootstrap.Alert(flashDiv);
                    bsAlert.close();
                }
            }, 5000);
        }
    });
</script>
@livewireScripts
</body>
</html>
