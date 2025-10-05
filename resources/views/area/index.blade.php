<x-layout>
    <section class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/main">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Объекты</li>
            </ol>

            <a class="btn btn-primary" href="/area/create">Создать</a>
        </nav>

        <div class="main-content">
            @foreach($areas as $area)
                <div class="card area-card" style="width: 18rem;">
                    <img src="https://w7.pngwing.com/pngs/424/251/png-transparent-color-wheel-habersetzer-und-kollegen-gmbh-color-theory-color-scheme-location-logo-television-logo-color.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="/area/{{ $area->area_id }}">
                            <h5 class="card-title">{{ $area->name }}</h5>
                        </a>
                        <p class="card-text">{{ $area->description }}</p>
                        <ul>
                            <li>Оплаченных дней:&nbsp;<span title="Кол-во оставшихся оплаченных дней, начиная с  сегодняшнего" class="badge bg-primary">{{ $area->paid_days }}</span></li>
                            <li>Лимит точек:&nbsp;<span title="Максимальное кол-во точек, доступных для заведения" class="badge bg-primary">{{ $area->point_limit }}</span></li>
                        </ul>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownCardMenu{{ $area->area_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                Управление
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownCardMenu{{ $area->area_id }}">
                                <li><a class="dropdown-item" href="/area/{{ $area->area_id }}/edit">Изменить</a></li>
                                <li><a class="dropdown-item" href="#">Удалить</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layout>
