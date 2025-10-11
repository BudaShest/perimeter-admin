<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property int $point_limit
 * @property int $paid_days
 * @property $created_at
 * @property $updated_ar
 *
 * @property-read Point[] $points
 * @property-read Phone[] $phones
 * @property-read User[] $users
 */
final class Area extends Model
{
    /** @var string  */
    protected $table = "areas";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = ["name", "description", "point_limit", "paid_days", "image"];

    public $timestamps = true;

    public function points(): BelongsToMany
    {
        return $this->belongsToMany(Point::class, 'area_points');
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'area_users');
    }

    public function phones(): BelongsToMany {
        return $this->belongsToMany(Phone::class, 'area_phones');
    }
}
