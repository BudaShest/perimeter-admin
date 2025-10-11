<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $area_id
 * @property int $phone_id
 * @property $created_at
 * @property $updated_at
 */
final class AreaPhone extends Model
{
    /** @var bool */
    public $timestamps = true;
    /** @var string */
    protected $table = "area_phones";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = ["id", "area_id", "phone_id",];

}
