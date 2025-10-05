@php
    use App\Models\Department;

    /** @var Department[] $departments */
@endphp
<x-layout>
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/main">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Подразделения</li>
            </ol>

            <a class="btn btn-primary" href="/department/create">Создать</a>
        </nav>

        <div class="main-content">
            @foreach($departments as $department)
                <div class="card" style="width: 100%">
                    <a href="/department/{{ $department->department_id }}">
                        <h5 class="card-header">Подразделение "{{ $department->name }}"</h5>
                    </a>
                    <div class="card-body">
                        <h6>Объекты</h6>
                        <ul>
                            @foreach($department->areas as $area)
                                <li><a href="/area/{{ $area->area_id }}">{{ $area->name }}</a></li>
                            @endforeach
                        </ul>
                        <div class="dropdown">
                            <button
                                class="btn btn-primary dropdown-toggle"
                                type="button"
                                id="dropdownCardMenu{{ $department->department_id }}"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Управление
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownCardMenu{{ $department->department_id }}">
                                <li><a class="dropdown-item" href="/department/{{ $department->department_id }}/edit">Изменить</a></li>
                                <form method="post" class="delete-btn-form" action="/department/{{ $department->department_id }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Вы уверены что хотите удалить?')">
                                        <i class="bi bi-trash"></i>
                                        Удалить
                                    </button>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layout>
