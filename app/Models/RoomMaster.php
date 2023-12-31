<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMaster extends Model
{
    use HasFactory;

    public function roomSlots()
    {
        return $this->hasMany(RoomSlot::class);
    }
}
