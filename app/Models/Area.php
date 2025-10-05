<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $area_id
 * @property string $name
 * @property string $description
 * @property int $point_limit
 * @property int $paid_days
 * @property $created_at
 * @property $updated_ar
 *
 * @property-read Point[] $points
 */
final class Area extends Model
{
    /** @var string  */
    protected $table = "areas";
    /** @var string */
    protected $primaryKey = "area_id";
    /** @var string[] */
    protected $fillable = ["name", "description", "point_limit", "paid_days"];

    public $timestamps = true;

    public function points(): BelongsToMany
    {
        return $this->belongsToMany(Point::class, 'area_points', 'area_id', 'point_id');
    }
}
