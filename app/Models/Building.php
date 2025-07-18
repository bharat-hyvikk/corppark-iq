<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'building';

    protected $fillable = [
        'building_name',
        'building_address',
        'building_image',
    ];
}
