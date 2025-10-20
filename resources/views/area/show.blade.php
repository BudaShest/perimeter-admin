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

                        <div class="sortable-container" id="sortableContainer">
                            @foreach($area->points as $point)
                                <div draggable="true" class="card sortable-item">
                                    {{ $point->name }}
                                </div>
                            @endforeach
                        </div>

                        <div class="accordion pt-2" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        Accordion Item #1
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                     aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by
                                        default, until the collapse plugin adds the appropriate classes that we use to
                                        style each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions. You can modify any of this with custom
                                        CSS or overriding our default variables. It's also worth noting that just about
                                        any HTML can go within the <code>.accordion-body</code>, though the transition
                                        does limit overflow.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        Accordion Item #2
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the second item's accordion body.</strong> It is hidden by
                                        default, until the collapse plugin adds the appropriate classes that we use to
                                        style each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions. You can modify any of this with custom
                                        CSS or overriding our default variables. It's also worth noting that just about
                                        any HTML can go within the <code>.accordion-body</code>, though the transition
                                        does limit overflow.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        Accordion Item #3
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the third item's accordion body.</strong> It is hidden by
                                        default, until the collapse plugin adds the appropriate classes that we use to
                                        style each element. These classes control the overall appearance, as well as the
                                        showing and hiding via CSS transitions. You can modify any of this with custom
                                        CSS or overriding our default variables. It's also worth noting that just about
                                        any HTML can go within the <code>.accordion-body</code>, though the transition
                                        does limit overflow.
                                    </div>
                                </div>
                            </div>
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
