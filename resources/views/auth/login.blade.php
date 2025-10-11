@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="auth-container">
        <div class="card shadow">
            <div class="card-body p-4">
                <h2 class="text-center mb-4">Вход в аккаунт</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Запомнить меня</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">Войти</button>

                    <div class="text-center">
                        <a href="{{ route('register') }}" class="text-decoration-none">
                            Нет аккаунта? Зарегистрироваться
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
