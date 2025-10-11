@extends('layouts.app')

@section('title', 'Новое подразделение')

@section('content')
<section class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/main">Главная</a></li>
            <li class="breadcrumb-item"><a href="/area">Подразделения</a></li>
            <li class="breadcrumb-item active" aria-current="page">Новое подразделение</li>
        </ol>
    </nav>

    <div class="content">
        <form method="post" action="/department">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Название</label>
                <input name="name" type="text" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Описание</label>
                <input name="description" type="text" class="form-control">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
        </form>
    </div>
</section>
@endsection;
