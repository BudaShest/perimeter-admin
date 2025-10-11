<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $area_id
 */
final class Route extends Model
{
    /** @var bool */
    public $timestamps = true;
    /** @var string */
    protected $table = "routes";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = ["id", "name", "area_id",];

}
