<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 *
 */
class Area extends Model
{
    /** @var string  */
    protected $table = "areas";

    /** @var string */
    protected $primaryKey = "area_id";

    protected $fillable = ["name", "description", "point_limit", "paid_days"];
}
