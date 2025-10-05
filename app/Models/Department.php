<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $department_id
 * @property string $name
 * @property $created_at
 * @property $updated_ar
 *
 * @property-read Area[] $areas
 */
final class Department extends Model
{


    protected $table = "departments";

    protected $primaryKey = "department_id";

    public $timestamps = true;

    protected $fillable = ["name"];

    public function areas(): HasMany {
        return $this->hasMany(Area::class, 'department_id');
    }
}
