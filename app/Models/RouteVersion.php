<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        "id",
        "route_id",
        "version",
        "is_active",
        "valid_from",
        "valid_to",
    ];

}
