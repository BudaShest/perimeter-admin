@extends('layouts.app')

@section('title', 'Панель управления')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Панель управления</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5>Добро пожаловать, {{ Auth::user()->name }}!</h5>
                        <p class="mb-0">Вы успешно вошли в систему.</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>Информация о пользователе</h5>
                                    <p><strong>Имя:</strong> {{ Auth::user()->name }}</p>
                                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                    <p><strong>Дата регистрации:</strong> {{ Auth::user()->created_at->format('d.m.Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>Действия</h5>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning w-100 mb-2">Выйти</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
