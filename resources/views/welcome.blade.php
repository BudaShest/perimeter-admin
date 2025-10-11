@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="text-center py-5">
        <h1 class="display-4">Добро пожаловать!</h1>
        <p class="lead">Система управления обходами "Периметр"</p>

        @guest
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Регистрация</a>
            </div>
        @else
            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">Перейти в панель управления</a>
            </div>
        @endguest
    </div>
@endsection
