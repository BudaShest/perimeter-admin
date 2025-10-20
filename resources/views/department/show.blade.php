@php

use App\Models\Area;
use App\Models\Department;

/** @var Department $department */
/** @var Area[] $areas */
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

        <div class="main-content p-2">
            <h1>Подразделение "{{ $department->name }}"</h1>

            <table class="table m-2">
                <tbody>
                <tr>
                    <th scope="row">Действия</th>
                    <td>
                        <a href="/department/{{ $department->id }}/edit" class="btn btn-secondary">
                            <i class="bi bi-pencil"></i>
                            Изменить
                        </a>
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

            <div class="container departments-areas p-2">
                <h2>Объекты</h2>

                <form class="row align-items-end pt-2" method="post" action="/department/{{$department->id}}/link-areas">
                    @csrf
                    <div class="col-md-3">
                        <label for="areasSelect" class="form-label">Выберите объекты:</label>
                        <select id="areasSelect" class="form-select" name="areas[]" multiple placeholder="Выберите объекты...">
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary">+</button>
                    </div>
                </form>

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
                        <th>Действия</th>
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
                            <td>
                                <form method="post" action="/area/{{ $area->id }}/unlink-department">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Вы уверены что хотите отвязать объект?')" class="btn btn-danger" title="Отвязать">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection;
