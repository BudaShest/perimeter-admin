<x-layout>
    <section class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/main">Главная</a></li>
                <li class="breadcrumb-item"><a href="/area">Объекты</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $area->name }}</li>
            </ol>
        </nav>

        <div class="areas-content">
            <h1>Объект {{ $area->name }}</h1>
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">Действия</th>
                        <td>
                            <a href="/area/{{ $area->area_id }}/edit" class="btn btn-secondary">Изменить</a>
                            <form action="/area/{{ $area->area_id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены что хотите удалить?')">
                                    <i class="bi bi-trash"></i>
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Изображение</th>
                        <td>
                            <img src="https://w7.pngwing.com/pngs/424/251/png-transparent-color-wheel-habersetzer-und-kollegen-gmbh-color-theory-color-scheme-location-logo-television-logo-color.png" class="card-img-top" alt="...">
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
                        <td colspan="2">{{ $area->paid_days }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Лимит точек</th>
                        <td colspan="2">{{ $area->point_limit }}</td>
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
                            aria-selected="true">Точки</button>
                        <button
                            class="nav-link"
                            id="nav-profile-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-profile"
                            type="button" role="tab"
                            aria-controls="nav-profile"
                            aria-selected="false">Маршруты</button>
                        <button
                            class="nav-link"
                            id="nav-contact-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-contact"
                            type="button"
                            role="tab"
                            aria-controls="nav-contact"
                            aria-selected="false">Пользователи</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
