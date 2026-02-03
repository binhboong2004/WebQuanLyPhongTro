<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    protected $fillable = ['room_id', 'name', 'id_card', 'phone', 'is_registered'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
