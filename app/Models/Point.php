<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $uid
 * @property float $lat
 * @property float $lon
 *
 * @property-read Area[] $areas
 */
class Point extends Model
{

    /** @var bool */
    public $timestamps = true;
    /** @var string */
    protected $table = "points";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = ["id", "name", "uid", "lat", "lon"];

    public function areas(): BelongsToMany {
        return $this->belongsToMany(Area::class, 'area_points');
    }

}
