<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'name',
        'days_of_week',
        'start_time',
        'end_time',
        'is_active'
    ];

    protected $casts = [
        'days_of_week' => 'array',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean'
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    // Проверка, активен ли график для указанного дня недели
    public function isActiveForDay(int $dayOfWeek): bool
    {
        return in_array($dayOfWeek, $this->days_of_week ?? []);
    }

    // Получить расписание на сегодня
    public function isActiveToday(): bool
    {
        return $this->isActiveForDay(now()->dayOfWeekIso);
    }

    // Получить расписание в читаемом формате
    public function getDaysOfWeekTextAttribute(): string
    {
        $daysMap = [
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
            7 => 'Вс'
        ];

        $days = array_map(function($day) use ($daysMap) {
            return $daysMap[$day] ?? $day;
        }, $this->days_of_week ?? []);

        return implode(', ', $days);
    }

    // Получить время в формате
    public function getTimeRangeAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }
}
