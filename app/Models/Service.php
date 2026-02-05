<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'unit', 'price_per_unit', 'building_id', 'room_id'];

    public function building()
    {
        return $this->belongsTo(\App\Models\Building::class);
    }

    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class);
    }
}
