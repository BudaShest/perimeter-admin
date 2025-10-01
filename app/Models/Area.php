<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function points(): BelongsToMany
    {
        return $this->belongsToMany(Point::class, 'points_areas', 'area_id', 'point_id');
    }
}
