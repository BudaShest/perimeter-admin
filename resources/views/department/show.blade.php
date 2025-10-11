@php
    /** @var \App\Models\Department $department */
@endphp

@extends('layouts.app')

@section('title', 'Подразделение ' . $department->name)

@section('content')
    <section class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/main">Главная</a></li>
                <li class="breadcrumb-item"><a href="/department">Подразделения</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $department->name }}</li>
            </ol>
        </nav>

        <div class="main-content">
            <h1>Подразделение {{ $department->name }}</h1>

            <table class="table p-2">
                <tbody>
                <tr>
                    <th scope="row">Действия</th>
                    <td>
                        <a href="/department/{{ $department->id }}/edit" class="btn btn-secondary">Изменить</a>
                        <form method="post" class="delete-btn-form" action="/department/{{ $department->id }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Вы уверены что хотите удалить?')">
                                <i class="bi bi-trash"></i>
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Название</th>
                    <td>{{ $department->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Описание</th>
                    <td>{{ $department->description }}</td>
                </tr>
                </tbody>
            </table>

            <div class="container departments-areas">
                <h2>Объекты</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            Имя
                        </th>
                        <th>
                            Лимит точек
                        </th>
                        <th>
                            Кол-во олпаченных дней
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($department->areas as $area)
                        <tr>
                            <td>
                                <a href="/area/{{ $area->id }}">{{ $area->name }}</a>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $area->point_limit }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $area->paid_days }}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection;
