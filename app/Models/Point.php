<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $point_id
 * @property string $name
 * @property string $uid
 * @property float $lat
 * @property float $lon
 */
class Point extends Model
{
    /** @var string */
    protected $table = "points";
    /** @var string */
    protected $primaryKey = "point_id";
    /** @var string[] */
    protected $fillable = ["point_id", "name", "uid", "lat", "lon"];
}
