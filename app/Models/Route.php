<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $area_id
 */
final class Route extends Model
{
    /** @var bool */
    public $timestamps = true;
    /** @var string */
    protected $table = "routes";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = ["name", "area_id"];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function routeVersions(): HasMany
    {
        return $this->hasMany(RouteVersion::class);
    }

    // Добавляем отношение с расписаниями
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    // Активные расписания
    public function activeSchedules()
    {
        return $this->schedules()->where('is_active', true);
    }

    // Получить активную версию маршрута
    public function activeVersion()
    {
        return $this->routeVersions()
            ->where('is_active', true)
            ->first();
    }

    // Получить последнюю версию маршрута
    public function latestVersion()
    {
        return $this->routeVersions()
            ->orderBy('version', 'desc')
            ->first();
    }
}
