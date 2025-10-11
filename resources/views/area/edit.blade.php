@extends('layouts.app')

@section('title', 'Изменение объекта')

@section('content')
<section class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/main">Главная</a></li>
            <li class="breadcrumb-item"><a href="/area">Объекты</a></li>
            <li class="breadcrumb-item active" aria-current="page">Редактирование {{ $area->name }}</li>
        </ol>
    </nav>

    <div class="main-content">
        <form method="post" action="/area/{{ $area->area_id }}">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Название</label>
                <input
                    name="name"
                    value="{{ old('name', $area->name) }}"
                    type="text"
                    class="form-control"
                >
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Описание</label>
                <input
                    name="description"
                    value="{{ old('description', $area->description) }}"
                    type="text"
                    class="form-control"
                >
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Максимальное кол-во точек</label>
                <input
                    name="point_limit"
                    value="{{ old('point_limit', $area->point_limit) }}"
                    type="number"
                    class="form-control"
                >
            </div>

            {{--       //todo заменить на дату конца?         --}}
            <div class="mb-3">
                <label for="" class="form-label">Кол-во оплаченных дней</label>
                <input
                    name="paid_days"
                    value="{{ old('paid_days', $area->paid_days) }}"
                    type="number"
                    class="form-control"
                >
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Дата конца контракта</label>
                <input type="datetime-local" class="form-control">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</section>
@endsection;
