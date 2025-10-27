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

                                                <!-- НОВЫЙ БЛОК: Расписания обходов -->
                                                <div class="mt-4 border-top pt-3">
                                                    <h6>📅 Расписания обходов</h6>

                                                    <!-- Список существующих расписаний -->
                                                    <div id="schedules-list-{{ $route->id }}">
                                                        @foreach($route->schedules as $schedule)
                                                            <div class="card mb-2 schedule-item" data-schedule-id="{{ $schedule->id }}">
                                                                <div class="card-body py-2">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <strong>{{ $schedule->name }}</strong>
                                                                            <br>
                                                                            <small class="text-muted">
                                                                                {{ $schedule->days_of_week_text }} | {{ $schedule->time_range }}
                                                                            </small>
                                                                        </div>
                                                                        <div>
                                                                            @if($schedule->is_active)
                                                                                <span class="badge bg-success">Активно</span>
                                                                            @else
                                                                                <span class="badge bg-secondary">Неактивно</span>
                                                                            @endif
                                                                            <button class="btn btn-sm btn-outline-danger ms-2"
                                                                                    onclick="deleteSchedule({{ $schedule->id }})">
                                                                                🗑️
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Форма создания нового расписания -->
                                                    <div class="card mt-3">
                                                        <div class="card-body">
                                                            <h6>Добавить расписание</h6>
                                                            <form id="schedule-form-{{ $route->id }}" class="schedule-form">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Название</label>
                                                                        <input type="text" name="name" class="form-control" placeholder="Утренний обход" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Время начала</label>
                                                                        <input type="time" name="start_time" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Время окончания</label>
                                                                        <input type="time" name="end_time" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label class="form-label">Активно</label>
                                                                        <select name="is_active" class="form-select">
                                                                            <option value="1">Да</option>
                                                                            <option value="0">Нет</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-2">
                                                                    <div class="col-12">
                                                                        <label class="form-label">Дни недели</label>
                                                                        <div class="d-flex flex-wrap gap-2">
                                                                            @foreach([1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 5 => 'Пт', 6 => 'Сб', 7 => 'Вс'] as $value => $label)
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox"
                                                                                           name="days_of_week[]" value="{{ $value }}" id="day{{ $value }}_{{ $route->id }}">
                                                                                    <label class="form-check-label" for="day{{ $value }}_{{ $route->id }}">
                                                                                        {{ $label }}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <button type="submit" class="btn btn-primary btn-sm">Добавить расписание</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- КОНЕЦ БЛОКА РАСПИСАНИЙ -->

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

<script>
    // Глобальные функции для работы с маршрутами
    function editRoute(routeId) {
        window.location.href = `/routes/${routeId}/edit`;
    }

    function createNewVersion(routeId) {
        if (confirm('Создать новую версию этого маршрута?')) {
            fetch('{{ route("routes.create-version") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    route_id: routeId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Новая версия маршрута создана!');
                        location.reload();
                    } else {
                        alert('Ошибка: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при создании версии');
                });
        }
    }

    function deleteRoute(routeId) {
        if (confirm('Вы уверены, что хотите удалить этот маршрут? Это действие нельзя отменить.')) {
            fetch(`/routes/${routeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Маршрут удален!');
                        location.reload();
                    } else {
                        alert('Ошибка: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при удалении маршрута');
                });
        }
    }

    // Глобальные функции для работы с расписаниями
    function deleteSchedule(scheduleId) {
        if (confirm('Удалить это расписание?')) {
            fetch(`/schedules/${scheduleId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-schedule-id="${scheduleId}"]`).remove();
                        showAlert('Расписание удалено!', 'success');
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Ошибка: ' + error.message, 'error');
                });
        }
    }

    // Вспомогательные функции
    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }

    function createSchedule(form) {
        const routeId = form.closest('.accordion-item').querySelector('.accordion-button')
            .getAttribute('aria-controls').replace('collapse', '');

        const formData = new FormData(form);

        const daysOfWeek = [];
        form.querySelectorAll('input[name="days_of_week[]"]:checked').forEach(checkbox => {
            daysOfWeek.push(parseInt(checkbox.value));
        });

        formData.delete('days_of_week[]');

        daysOfWeek.forEach(day => {
            formData.append('days_of_week[]', day);
        });

        fetch(`/routes/${routeId}/schedules`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    addScheduleToList(routeId, data.schedule);
                    form.reset();
                    showAlert('Расписание создано!', 'success');
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Ошибка: ' + error.message, 'error');
            });
    }

    function addScheduleToList(routeId, schedule) {
        const schedulesList = document.getElementById(`schedules-list-${routeId}`);

        const scheduleHtml = `
            <div class="card mb-2 schedule-item" data-schedule-id="${schedule.id}">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${schedule.name}</strong>
                            <br>
                            <small class="text-muted">
                                ${schedule.days_of_week_text} | ${schedule.time_range}
                            </small>
                        </div>
                        <div>
                            ${schedule.is_active ?
            '<span class="badge bg-success">Активно</span>' :
            '<span class="badge bg-secondary">Неактивно</span>'
        }
                            <button class="btn btn-sm btn-outline-danger ms-2"
                                    onclick="deleteSchedule(${schedule.id})">
                                🗑️
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        schedulesList.insertAdjacentHTML('beforeend', scheduleHtml);
    }

    // Инициализация после загрузки DOM
    document.addEventListener('DOMContentLoaded', function() {
        // Обработчик для создания первого маршрута
        const createFirstRouteBtn = document.getElementById('createFirstRoute');
        if (createFirstRouteBtn) {
            createFirstRouteBtn.addEventListener('click', function() {
                window.location.href = '{{ route("routes.create", ["area" => $area->id]) }}';
            });
        }

        // Обработчики для форм расписаний
        document.querySelectorAll('.schedule-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                createSchedule(this);
            });
        });
    });
</script>
