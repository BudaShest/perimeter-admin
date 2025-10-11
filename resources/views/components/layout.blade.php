<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else

    @endif
</head>
<body>
<div class="wrapper">
    <header class="site-header">
        <nav class="container">
            <div class="logo">
            </div>

            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/department">Подразделения</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/area">Объекты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>

            <button class="btn btn-danger">Выйти</button>
        </nav>
    </header>
    <main class="site-main">
        {{ $slot }}
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
</div>
</body>
</html>
