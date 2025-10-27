<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteVersion;
use App\Models\RouteVersionPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function saveOrder(Request $request) {
        try {
            $request->validate([
                'area_id' => 'required|exists:areas,id',
                'point_order' => 'required|array',
                'point_order.*' => 'exists:points,id',
            ]);

            $areaId = $request->area_id;
            $pointOrder = $request->point_order;
            $routeVersionId = $request->route_version_id;

            DB::transaction(function () use ($areaId, $pointOrder, $routeVersionId) {
                // Если route_version_id не передан, создаем новый маршрут и версию
                if (!$routeVersionId) {
                    // Создаем маршрут
                    $route = Route::create([
                        'name' => 'Маршрут для зоны ' . $areaId,
                        'area_id' => $areaId,
                    ]);

                    // Создаем версию маршрута
                    $routeVersion = RouteVersion::create([
                        'route_id' => $route->id,
                        'version' => 1,
                        'is_active' => true,
                        'valid_from' => now(),
                    ]);

                    $routeVersionId = $routeVersion->id;
                } else {
                    // Используем существующую версию маршрута
                    $routeVersion = RouteVersion::findOrFail($routeVersionId);

                    // Удаляем старые точки маршрута
                    RouteVersionPoint::where('route_version_id', $routeVersionId)->delete();
                }

                // Сохраняем точки в правильном порядке
                foreach ($pointOrder as $order => $pointId) {
                    RouteVersionPoint::create([
                        'route_version_id' => $routeVersionId,
                        'point_id' => $pointId,
                        'step_order' => $order + 1, // порядок начинается с 1
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Маршрут успешно сохранен',
                'route_version_id' => $routeVersionId ?? null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сохранения: ' . $e->getMessage()
            ], 500);
        }
    }

    //todo edit
    public function edit(Route $route)
    {
        $route->load(['routeVersions.points' => function($query) {
            $query->orderBy('step_order');
        }]);

        return view('routes.edit', compact('route'));
    }

    //todo edit
    public function create(Area $area)
    {
        return view('routes.create', compact('area'));
    }

    public function destroy(Route $route)
    {
        try {
            DB::transaction(function () use ($route) {
                // Удаляем все версии и связанные точки
                foreach ($route->routeVersions as $version) {
                    $version->routeVersionPoints()->delete();
                }
                $route->routeVersions()->delete();
                $route->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Маршрут успешно удален'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка удаления: ' . $e->getMessage()
            ], 500);
        }
    }
}
