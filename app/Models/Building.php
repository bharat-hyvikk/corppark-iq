<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'building';

    protected $fillable = [
        'building_name',
        'building_address',
        'building_image',
    ];

    // submanager
    public function managers()
    {
        return $this->hasMany(User::class, 'building_id', 'id');
    }

    public function offices()
    {
        return $this->hasMany(Office::class, 'building_id', 'id');
    }

    public function vehicles()
    {
        return $this->hasManyThrough(
            \App\Models\Vehicle::class,
            \App\Models\Office::class,
            'building_id', // Foreign key on Office
            'office_id',   // Foreign key on Vehicle
            'id',          // Local key on Building
            'id'           // Local key on Office
        );
    }

    // get qr codes through has many through

    public function qrCodes()
    {
        return $this->hasManyThrough(
            QrCode::class,
            Office::class,
            'building_id', // Foreign key on Office
            'office_id',   // Foreign key on QrCode
            'id',          // Local key on Building
            'id'           // Local key on Office
        );
    }
}
