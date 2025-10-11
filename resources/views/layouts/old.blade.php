<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <style>
        .navbar-brand { font-weight: bold; }
        .auth-container { max-width: 400px; margin: 100px auto; }
        .flash-message { position: fixed; top: 20px; right: 20px; z-index: 1050; }

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
        <a class="navbar-brand" href="/">Мой сайт</a>

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
        <ul>
            <li>
                <a href="">budashest@gmail.com</a>
            </li>
            <li>
                <a href="">+7-995-472-06-14</a>
            </li>
        </ul>
    </div>
</footer>
</body>
</html>
