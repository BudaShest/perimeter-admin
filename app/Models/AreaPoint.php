<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $area_id
 * @property int $point_id
 * @property $created_at
 * @property $updated_at
 */
final class AreaPoint extends Model
{
    /** @var string  */
    protected $table = "area_points";

    /** @var string  */
    protected $primaryKey = 'id';

    /** @var string[]  */
    protected $fillable = ['area_id', 'point_id'];
    /** @var bool  */
    protected $incrementing = true;
    /** @var bool  */
    protected $timestamps = true;
}
