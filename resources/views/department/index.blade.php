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
                <div class="card">
                    <h5 class="card-header">{{ $department->name }}</h5>
                    <div class="card-body">
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layout>
