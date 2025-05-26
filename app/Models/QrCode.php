<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    //
    protected $fillable = [
        'vehicle_id',
        'qr_code',
        'unique_code',
        'office_id',
    ];
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
