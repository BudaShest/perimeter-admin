<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $description
 * @property int $point_limit
 * @property int $paid_days
 */
class Area extends Model
{
    /** @var string  */
    protected $table = "areas";
    /** @var string */
    protected $primaryKey = "area_id";
    /** @var string[] */
    protected $fillable = ["name", "description", "point_limit", "paid_days"];
}
