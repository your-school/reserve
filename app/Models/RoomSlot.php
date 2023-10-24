<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_master_id',
        'day',
        'stock',
    ];

    public function roomMaster()
    {
        return $this->belongsTo(RoomMaster::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_rooms')->withPivot('id', 'price');
    }

    public function scopeLatestOrder($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }

    public function planRooms()
    {
        return $this->hasMany(PlanRoom::class);
    }
}
