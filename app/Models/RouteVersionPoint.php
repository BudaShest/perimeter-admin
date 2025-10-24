<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $route_version_id
 * @property $point_id
 * @property $step_order
 */
class RouteVersionPoint extends Model
{
    /** @var bool */
    public $timestamps = true;
    /** @var string */
    protected $table = "route_version_points";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = [
        "route_version_id",
        "point_id",
        "step_order",
    ];

    public function routeVersion(): BelongsTo
    {
        return $this->belongsTo(RouteVersion::class);
    }

    public function point(): BelongsTo
    {
        return $this->belongsTo(Point::class);
    }
}
