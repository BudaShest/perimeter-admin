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
        "id",
        "route_version_id",
        "point_id",
        "step_order",
    ];

}
