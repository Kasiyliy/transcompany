<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['license_plate', 'longitude', 'latitude', 'status', 'description'];
}
