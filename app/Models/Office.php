<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory,SoftDeletes;
   

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }
}
