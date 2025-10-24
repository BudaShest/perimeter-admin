<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $route_id
 * @property $version
 * @property $is_active
 * @property $valid_from
 * @property $valid_to
 */
final class RouteVersion extends Model
{
    /** @var bool */
    public $timestamps = true;
    /** @var string */
    protected $table = "route_versions";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = [
        "route_id",
        "version",
        "is_active",
        "valid_from",
        "valid_to",
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function routeVersionPoints(): HasMany
    {
        return $this->hasMany(RouteVersionPoint::class);
    }

    public function points()
    {
        return $this->belongsToMany(Point::class, 'route_version_points')
            ->withPivot('step_order')
            ->orderBy('step_order');
    }
}
