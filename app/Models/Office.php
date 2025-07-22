<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Office extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::creating(function ($office) {
            $user = Auth::user();
            if (!$office->canModify($user, 'office.add')) {
                abort(403, 'You do not have permission to create  office.');
            }
        });
        static::updating(function ($office) {
            $user = Auth::user();
            if (!$office->canModify($user, 'office.update')) {
                abort(403, 'You do not have permission to update  office.');
            }
        });

        static::deleting(function ($office) {
            $user = Auth::user();
            if (!$office->canModify($user, 'office.delete')) {
                abort(403, 'You do not have permission to delete  office.');
            }
        });
    }


    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }


    public function canModify($user, $action)
    {
        // Type 1: Super Admin – can do anything
        if ($user->user_type == 1) {
            return true;
        }

        // Type 2: Manager – only if building matches
        if ($user->user_type == 2) {
            return $this->building_id == $user->building_id;
        }

        // Type 3: Submanager – check building and permission
        if ($user->user_type == 3) {
            $hasPermission = $user->hasPermissionTo($action); // example: 'edit', 'update', 'delete'
            return $this->building_id == $user->building_id && $hasPermission;
        }

        return false; // For other user types
    }
}
