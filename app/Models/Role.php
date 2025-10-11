<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
final class Role extends Model
{
    /** @var string  */
    protected $table = "roles";
    /** @var string */
    protected $primaryKey = "id";

    protected $fillable = ['name'];

    public $timestamps = true;
}
