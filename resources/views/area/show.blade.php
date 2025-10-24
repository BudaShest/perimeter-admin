@php
use App\Models\Area;
use App\Models\User;

/** @var Area $area */
/** @var Users[] $allUsers */
@endphp

@extends('layouts.app')

@section('title', 'Объект ' . $area->name)

@section('content')
    <section class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/main">Главная</a></li>
                <li class="breadcrumb-item"><a href="/area">Объекты</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $area->name }}</li>
            </ol>
        </nav>

        <div class="main-content p-2">
            <h1>Объект "{{ $area->name }}"</h1>

            <table class="table m-2">
                <tbody>
                <tr>
                    <th scope="row">Действия</th>
                    <td>
                        <a href="/area/{{ $area->id }}/edit" class="btn btn-secondary">Изменить</a>
                        <form class="delete-btn-form" method="post" action="/area/{{ $area->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Вы уверены что хотите удалить?')">
                                <i class="bi bi-trash"></i>
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Изображение</th>
                    <td>
                        <img
                            src="{{ $area->image ?? "https://w7.pngwing.com/pngs/424/251/png-transparent-color-wheel-habersetzer-und-kollegen-gmbh-color-theory-color-scheme-location-logo-television-logo-color.png" }}"
                            class="card-img-top" alt="...">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Название</th>
                    <td>{{ $area->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Описание</th>
                    <td>{{ $area->description }}</td>
                </tr>
                <tr>
                    <th scope="row">Кол-во оплаченных дней</th>
                    <td colspan="2">
                        <span class="badge bg-primary">{{ $area->paid_days }}</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Лимит точек</th>
                    <td colspan="2">
                        <span class="badge bg-primary">{{ $area->point_limit }}</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Дата создания</th>
                    <td colspan="2">{{ $area->created_at }}</td>
                </tr>
                <tr>
                    <th scope="row">Дата обновления</th>
                    <td colspan="2">{{ $area->updated_at }}</td>
                </tr>
                </tbody>
            </table>

            <div class="m-2">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button
                            class="nav-link active"
                            id="nav-home-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-home"
                            type="button"
                            role="tab"
                            aria-controls="nav-home"
                            aria-selected="true">Точки
                        </button>
                        <button
                            class="nav-link routes-link"
                            id="nav-profile-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-profile"
                            type="button" role="tab"
                            aria-controls="nav-profile"
                            aria-selected="false">Маршруты
                        </button>
                        <button
                            class="nav-link"
                            id="nav-contact-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-contact"
                            type="button"
                            role="tab"
                            aria-controls="nav-contact"
                            aria-selected="false">Пользователи
                        </button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active pt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form class="row" method="post" action="/point/store-and-link/{{ $area->id }}/">
                            @csrf
                            <div class="mb-3 col">
                                <label class="form-label" for="">Название</label>
                                <input name="name" class="form-control" type="text">
                            </div>
                            <div class="mb-3 col">
                                <label class="form-label" for="">UID Карты</label>
                                <input name="uid" class="form-control" type="text">
                            </div>
                            <div class="mb-3 col align-content-end">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i></button>
                            </div>
                        </form>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="row">
                                    Название
                                </th>
                                <th scope="row">
                                    UID Карты
                                </th>
                                <th>
                                    Действия
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($area->points as $point)
                                <tr>
                                    <td>
                                        {{ $point->name }}
                                    </td>
                                    <td>
                                        {{ $point->uid }}
                                    </td>
                                    <td>
                                        <form method="post" action="/point/{{ $point->id }}/unlink-area/{{ $area->id }}">
                                            @method('DELETE')
                                            @csrf
                                            <button onclick="return confirm('Вы уверены что хотите отвязать точку?')" class="btn btn-danger" title="Отвязать">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade pt-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <button class="btn btn-secondary">
                            Создать маршрут
                        </button>

                        <form class="sortable-container" id="sortableContainer">
                            @csrf
                            <input type="hidden" name="area_id" value="{{ $area->id }}">
                            <input type="hidden" name="route_version_id" value="{{ $routeVersion->id ?? '' }}">

                            <div class="sortable-list">
                                @foreach($area->points as $point)
                                    <div class="sortable-item card row" draggable="true" data-point-id="{{ $point->id }}">
                                        <input type="text" class="form-control" value="{{ $point->name }}" readonly>
                                        <input type="hidden" name="point_order[]" value="{{ $point->id }}">
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3 mt-3">
                                <button type="button" class="btn btn-primary" id="saveRoute">Сохранить порядок</button>
                                <span id="saveStatus" class="ms-2"></span>
                            </div>
                        </form>

                        <div class="accordion pt-2" id="routesAccordion">
                            @forelse($area->routes as $index => $route)
                                @php
                                    $activeVersion = $route->routeVersions->where('is_active', true)->first()
                                                   ?? $route->routeVersions->sortByDesc('version')->first();
                                @endphp

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $route->id }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $route->id }}"
                                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $route->id }}">
                                            🗺️ Маршрут: {{ $route->name }}
                                            <span class="badge bg-secondary ms-2">
                        Версия {{ $activeVersion->version ?? '1' }}
                    </span>
                                            @if($activeVersion->is_active ?? false)
                                                <span class="badge bg-success ms-1">Активна</span>
                                            @else
                                                <span class="badge bg-warning ms-1">Неактивна</span>
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $route->id }}"
                                         class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                         aria-labelledby="heading{{ $route->id }}"
                                         data-bs-parent="#routesAccordion">
                                        <div class="accordion-body">
                                            @if($activeVersion && $activeVersion->points->count() > 0)
                                                <div class="mb-3">
                                                    <h6>Точки маршрута ({{ $activeVersion->points->count() }}):</h6>
                                                    <div class="list-group">
                                                        @foreach($activeVersion->points as $point)
                                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="badge bg-primary me-2">{{ $loop->iteration }}</span>
                                                                    {{ $point->name }}
                                                                </div>
                                                                <small class="text-muted">UID: {{ $point->uid }}</small>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Дата создания:</strong>
                                                        {{ $activeVersion->created_at }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if($activeVersion->valid_from)
                                                            <strong>Действует с:</strong>
                                                            {{ $activeVersion->valid_from }}
                                                        @endif
                                                        @if($activeVersion->valid_to)
                                                            <br><strong>Действует до:</strong>
                                                            {{ $activeVersion->valid_to }}
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mt-3">
                                                    <button class="btn btn-outline-primary btn-sm me-2"
                                                            onclick="editRoute({{ $route->id }})">
                                                        ✏️ Редактировать
                                                    </button>
                                                    <button class="btn btn-outline-success btn-sm me-2"
                                                            onclick="createNewVersion({{ $route->id }})">
                                                        🆕 Новая версия
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm"
                                                            onclick="deleteRoute({{ $route->id }})">
                                                        🗑️ Удалить
                                                    </button>
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    <p class="mb-0">В этом маршруте пока нет точек.</p>
                                                    <button class="btn btn-primary btn-sm mt-2"
                                                            onclick="editRoute({{ $route->id }})">
                                                        Добавить точки
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    <h6>Маршруты не найдены</h6>
                                    <p class="mb-0">Для этой зоны ещё не создано ни одного маршрута.</p>
                                    <button class="btn btn-primary btn-sm mt-2" id="createFirstRoute">
                                        Создать первый маршрут
                                    </button>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <div class="tab-pane fade pt-3" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="row">
                            <form class="row align-items-end pt-2" method="post" action="/area/{{ $area->id }}/link-users">
                                @csrf
                                <div class="col">
                                    <label for="usersSelect" class="form-label">Выберите пользователей</label>
                                    <select name="users[]" id="usersSelect" multiple class="form-select" placeholder="Выберите пользователей">
                                        @foreach($allUsers as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </form>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Логин</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($area->users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <form action="/user/{{ $user->id }}/unlink-area/{{ $area->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите отвязать пользователя')">
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
                </div>
            </div>
        </div>
    </section>
@endsection;
