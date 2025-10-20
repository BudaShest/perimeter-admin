<?php


use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PatrolController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::controller(AreaController::class)->group(function () {
    Route::get("/area", "index");
    Route::get("/area/create", "create");
    Route::post("/area", "store");
    Route::get("/area/{id}", "show");
    Route::get("/area/{id}/edit", "edit");
    Route::put("/area/{id}", "update");
    Route::delete("/area/{id}", "destroy");
    Route::delete("/area/{id}/unlink-department", "unlinkDepartment");

    Route::post("/area/{id}/link-users", "linkUsers");
});

Route::controller(DepartmentController::class)->group(function () {
   Route::get("/department", "index");
   Route::get("/department/create", "create");
   Route::post("/department", "store");
   Route::get("/department/{id}", "show");
   Route::get("/department/{id}/edit", "edit");
   Route::put("/department/{id}", "update");
   Route::delete("/department/{id}", "destroy");
   Route::post("/department/{id}/link-areas", "linkAreas");
});

Route::controller(PointController::class)->group(function () {
//    Route::get("/point", "index");
    Route::post("/point", "store");
    Route::delete("/point/{id}/unlink-area/{area_id}", "unlinkArea");
    Route::post("/point/store-and-link/{areaID}", "storeAndLink");
});

Route::controller(PatrolController::class)->group(function () {
    Route::get("/patrol", "index");
});

Route::controller(UserController::class)->group(function () {
    Route::delete('/user/{id}/unlink-area/{area_id}', "unlinkArea");

});

// todo autogeenrated stuff

Route::get('/info', function () {
    Log::info('Phpinfo page visited');
    return phpinfo();
});

Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');
Route::post('/theme/set/{theme}', [ThemeController::class, 'setTheme'])->name('theme.set');
Route::get('/theme/current', [ThemeController::class, 'getTheme'])->name('theme.current');

// Публичные маршруты
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Защищенные маршруты
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Главная страница (доступна всем)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function () {
    $status = [];

    // Check Database Connection
    try {
        DB::connection()->getPdo();
        // Optionally, run a simple query
        DB::select('SELECT 1');
        $status['database'] = 'OK';
    } catch (\Exception $e) {
        $status['database'] = 'Error';
    }

    // Check Redis Connection
    try {
        Cache::store('redis')->put('health_check', 'OK', 10);
        $value = Cache::store('redis')->get('health_check');
        if ($value === 'OK') {
            $status['redis'] = 'OK';
        } else {
            $status['redis'] = 'Error';
        }
    } catch (\Exception $e) {
        $status['redis'] = 'Error';
    }

    // Check Storage Access
    try {
        $testFile = 'health_check.txt';
        Storage::put($testFile, 'OK');
        $content = Storage::get($testFile);
        Storage::delete($testFile);

        if ($content === 'OK') {
            $status['storage'] = 'OK';
        } else {
            $status['storage'] = 'Error';
        }
    } catch (\Exception $e) {
        $status['storage'] = 'Error';
    }

    // Determine overall health status
    $isHealthy = collect($status)->every(function ($value) {
        return $value === 'OK';
    });

    $httpStatus = $isHealthy ? 200 : 503;

    return response()->json($status, $httpStatus);
});
