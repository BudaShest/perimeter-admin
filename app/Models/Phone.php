<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $model
 * @property string $imei
 */
final class Phone extends Model
{
    /** @var string  */
    protected $table = "phones";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = ["model", "imei",];

    public $timestamps = true;
}
