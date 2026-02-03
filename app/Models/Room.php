<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['building_id', 'room_number', 'price_base', 'status'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    public function members()
    {
        return $this->hasMany(RoomMember::class);
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function readings()
    {
        return $this->hasMany(ServiceReading::class);
    }
}
