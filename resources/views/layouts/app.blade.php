<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; }
        .auth-container { max-width: 400px; margin: 100px auto; }
        .flash-message { position: fixed; top: 20px; right: 20px; z-index: 1050; }
    </style>
</head>
<body>
<!-- Навигация -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Мой сайт</a>

        <div class="navbar-nav ms-auto">
            @auth
                <span class="navbar-text me-3">Привет, {{ Auth::user()->name }}!</span>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
