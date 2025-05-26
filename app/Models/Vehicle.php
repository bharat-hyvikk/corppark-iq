<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;
    protected $fillable = [
        'vehicle_number',
        'owner_phone',
        'office_id',
        'check_in_status',
        'check_in_time',
        'check_out_time',
    ];
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    // qr code relation
    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }
    // format check in and check out time and cast them to date 
    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];
    // format check in and check out time to date
    public function getCheckInTimeAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s') : null;
    }

    public function getCheckOutTimeAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s') : null;
    }
}
