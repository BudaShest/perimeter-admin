<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $department_id
 * @property string $name
 * @property $created_at
 * @property $updated_ar
 */
final class Department extends Model
{


    protected $table = "departments";

    protected $primaryKey = "department_id";

    public $timestamps = true;

    protected $fillable = ["name"];
}
