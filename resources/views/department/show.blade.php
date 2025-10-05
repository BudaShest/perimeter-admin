@php
/** @var \App\Models\Department $department */
@endphp
<x-layout>
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

        <table class="table">
            <tbody>
            <tr>
                <th scope="row">Действия</th>
                <td>
                    <a href="/department/{{ $department->department_id }}/edit" class="btn btn-secondary">Изменить</a>
                    <form method="post" class="delete-btn-form" action="/department/{{ $department->department_id }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены что хотите удалить?')">
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
                <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ipsa nulla provident?</td>
            </tr>
            </tbody>
        </table>
        </div>
    </section>
</x-layout>
