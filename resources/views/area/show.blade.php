@php
use App\Models\Area;

/** @var Area $area */
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

        <div class="main-content">
            <h1>Объект {{ $area->name }}</h1>

            <table class="table">
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

            <div>
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
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form class="row" method="post" action="/point">
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
                                <button type="submit" class="btn btn-primary">Привязать</button>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <button class="btn btn-secondary">
                            Создать маршрут
                        </button>

                        <div class="sortable-container" id="sortableContainer">
                            @foreach($area->points as $point)
                                <div draggable="true" class="sortable-item">
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

                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach() @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection;
