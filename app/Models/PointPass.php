<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $patrol_id
 * @property int $point_id
 * @property $scanned_at
 * @property $status
 * @property string $comment
 * @property int $phone_id
 * @property int $reason_id
 * @property $gps_lat
 * @property $gps_lon
 * @property $gps_accuracy
 * @property $signature_hash
 */
final class PointPass extends Model
{
    /** @var bool */
    public $timestamps = true;
    /** @var string */
    protected $table = "point_passes";
    /** @var string */
    protected $primaryKey = "id";
    /** @var string[] */
    protected $fillable = [
        "id",
        "patrol_id",
        "point_id",
        "scanned_at",
        "status",
        "comment",
        "phone_id",
        "reason_id",
        "gps_lat",
        "gps_lon",
        "gps_accuracy",
        "signature_hash",
    ];

}
