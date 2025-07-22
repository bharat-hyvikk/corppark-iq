<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::creating(function ($vehicle) {
            $user = Auth::user();
            if (!$vehicle->canModify($user, 'vehicle.add')) {
                abort(403, 'You do not have permission to create  vehicle.');
            }
        });
        static::updating(function ($vehicle) {
            $user = Auth::user();
            if (!$vehicle->canModify($user, 'vehicle.update')) {
                abort(403, 'You do not have permission to update  vehicle.');
            }
        });

        static::deleting(function ($vehicle) {
            $user = Auth::user();
            if (!$vehicle->canModify($user, 'vehicle.delete')) {
                abort(403, 'You do not have permission to delete  vehicle.');
            }
        });
    }
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

    public function canModify($user, $action)
    {
        // Type 1: Super Admin – can do anything
        if ($user->user_type == 1) {
            return true;
        }

        // Type 2: Manager – only if building matches
        if ($user->user_type == 2) {
            return $this->office->building_id == $user->building_id;
        }

        // Type 3: Submanager – check building and permission
        if ($user->user_type == 3) {
            $hasPermission = $user->hasPermissionTo($action); // example: 'edit', 'update', 'delete'
            return $this->office->building_id == $user->building_id && $hasPermission;
        }

        return false; // For other user types
    }
}
