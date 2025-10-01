<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $area_id
 * @property int $point_id
 */
class AreaPoint extends Model
{
    protected $table = "area_points";

    protected $primaryKey = ['area_id', 'point_id'];

    protected $fillable = ['area_id', 'point_id'];

    protected $incrementing = false;

    protected $timestamps = true;
}
