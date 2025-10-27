<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    // Получить расписания для маршрута
    public function index(Route $route): JsonResponse
    {
        $schedules = $route->schedules()->get();

        return response()->json([
            'success' => true,
            'schedules' => $schedules
        ]);
    }

    public function store(Request $request, Route $route): JsonResponse
    {
        try {
            // Преобразуем days_of_week в массив, если пришла строка
            $daysOfWeek = $request->days_of_week;
            if (is_string($daysOfWeek)) {
                $daysOfWeek = json_decode($daysOfWeek, true);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'is_active' => 'sometimes|boolean',
            ]);

            // Добавляем days_of_week в validated данные
            $validated['days_of_week'] = $daysOfWeek;

            // Дополнительная валидация для days_of_week
            if (empty($validated['days_of_week']) || !is_array($validated['days_of_week'])) {
                throw new \Exception('Дни недели должны быть массивом');
            }

            foreach ($validated['days_of_week'] as $day) {
                if (!is_numeric($day) || $day < 1 || $day > 7) {
                    throw new \Exception('Некорректный день недели: ' . $day);
                }
            }

            $schedule = $route->schedules()->create($validated);

            // Загружаем отношения для ответа
            $schedule->load('route');

            return response()->json([
                'success' => true,
                'message' => 'Расписание создано',
                'schedule' => $schedule
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка создания: ' . $e->getMessage()
            ], 500);
        }
    }

    // Обновить расписание
    public function update(Request $request, Schedule $schedule): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'days_of_week' => 'sometimes|array',
                'days_of_week.*' => 'integer|between:1,7',
                'start_time' => 'sometimes|date_format:H:i',
                'end_time' => 'sometimes|date_format:H:i|after:start_time',
                'is_active' => 'sometimes|boolean',
            ]);

            $schedule->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Расписание обновлено',
                'schedule' => $schedule
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка обновления: ' . $e->getMessage()
            ], 500);
        }
    }

    // Удалить расписание
    public function destroy(Schedule $schedule): JsonResponse
    {
        try {
            $schedule->delete();

            return response()->json([
                'success' => true,
                'message' => 'Расписание удалено'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка удаления: ' . $e->getMessage()
            ], 500);
        }
    }

    // API: Получить обходы на текущий день
    public function getTodaySchedules(): JsonResponse
    {
        try {
            $today = now();
            $dayOfWeek = $today->dayOfWeekIso; // 1-7 (понедельник-воскресенье)
            $currentTime = $today->format('H:i:s');

            $schedules = Schedule::with(['route.area', 'route.activeVersion.points'])
                ->where('is_active', true)
                ->whereJsonContains('days_of_week', "$dayOfWeek")
//                ->where('start_time', '<=', $currentTime)
//                ->where('end_time', '>=', $currentTime)
                ->get();

            return response()->json([
                'success' => true,
                'date' => $today->format('Y-m-d'),
                'day_of_week' => $dayOfWeek,
                'current_time' => $currentTime,
                'schedules' => $schedules->map(function($schedule) {
                    return [
                        'id' => $schedule->id,
                        'name' => $schedule->name,
                        'time_range' => $schedule->time_range,
                        'route' => [
                            'id' => $schedule->route->id,
                            'name' => $schedule->route->name,
                            'area' => $schedule->route->area->name,
                        ],
                        'points' => $schedule->route->activeVersion?->points ?? []
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка получения расписаний: ' . $e->getMessage()
            ], 500);
        }
    }

    // API: Получить обходы на конкретный день
    public function getSchedulesByDate(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'date' => 'required|date'
            ]);

            $date = \Carbon\Carbon::parse($request->date);
            $dayOfWeek = $date->dayOfWeekIso;

            $schedules = Schedule::with(['route.area', 'route.activeVersion.points'])
                ->where('is_active', true)
                ->whereJsonContains('days_of_week', $dayOfWeek)
                ->get();

            return response()->json([
                'success' => true,
                'date' => $date->format('Y-m-d'),
                'day_of_week' => $dayOfWeek,
                'schedules' => $schedules
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка получения расписаний: ' . $e->getMessage()
            ], 500);
        }
    }
}
