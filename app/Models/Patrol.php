<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $start_ts
 * @property $end_ts
 * @property $status
 * @property $kind
 * @property $date_only
 * @property $area_id
 * @property $route_version_id
 * @property $created_at
 * @property $updated_at
 */
final class Patrol extends Model
{
    /** @var string */
    protected $table = "patrols";
    /** @var string  */
    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = [
        "name",
        "start_ts",
        "end_ts",
        "status",
        "kind",
        "date_only",
        "area_id",
        "route_version_id",
    ];
}
