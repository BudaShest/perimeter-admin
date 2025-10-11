<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property $created_at
 * @property $updated_ar
 *
 * @property-read Area[] $areas
 */
final class Department extends Model
{

    /** @var string */
    protected $table = "departments";
    /** @var string  */
    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = ["name", "description"];

    public function areas(): HasMany {
        return $this->hasMany(Area::class);
    }

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }
}
