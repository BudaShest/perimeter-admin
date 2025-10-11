@extends('layouts.app')

@section('title', 'Панель управления')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Панель управления</h4>
                    <div class="d-flex align-items-center">
                        <small class="text-muted me-2">Текущая тема:</small>
                        <span class="badge bg-secondary">{{ Auth::user()->theme === 'dark' ? 'Тёмная' : 'Светлая' }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5>Добро пожаловать, {{ Auth::user()->name }}!</h5>
                        <p class="mb-0">Вы успешно вошли в систему. Используйте переключатель в шапке для смены темы.</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>📊 Информация о пользователе</h5>
                                    <p><strong>Имя:</strong> {{ Auth::user()->name }}</p>
                                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                    <p><strong>Тема:</strong> {{ Auth::user()->theme === 'dark' ? 'Тёмная' : 'Светлая' }}</p>
                                    <p><strong>Дата регистрации:</strong> {{ Auth::user()->created_at->format('d.m.Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>⚡ Действия</h5>
                                    <div class="d-grid gap-2">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning w-100 mb-2">🚪 Выйти</button>
                                        </form>
                                        <button class="btn btn-outline-primary w-100" onclick="testTheme()">
                                            🎨 Протестировать тему
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Демонстрация элементов в разных темах -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Демонстрация элементов интерфейса:</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button class="btn btn-primary w-100 mb-2">Основная кнопка</button>
                                            <button class="btn btn-secondary w-100 mb-2">Вторичная кнопка</button>
                                            <button class="btn btn-success w-100 mb-2">Успех</button>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="check1" checked>
                                                <label class="form-check-label" for="check1">Чекбокс 1</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="check2">
                                                <label class="form-check-label" for="check2">Чекбокс 2</label>
                                            </div>
                                            <input type="text" class="form-control mt-2" placeholder="Текстовое поле">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="alert alert-warning">Предупреждение</div>
                                            <div class="progress mb-2">
                                                <div class="progress-bar" style="width: 65%">65%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testTheme() {
            alert('Текущая тема: ' + (document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'Тёмная' : 'Светлая'));
        }
    </script>
@endsection
