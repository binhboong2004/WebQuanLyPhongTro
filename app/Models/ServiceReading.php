<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceReading extends Model
{
    protected $fillable = ['room_id', 'reading_date', 'old_electricity_index', 'electricity_index', 'old_water_index', 'water_index', 'image_proof_elec', 'image_proof_water', 'status', 'admin_note', 'created_by'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
