<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'room_master_id',
        'day',
        'cancel',
    ];

    public function roomMaster()
    {
        return $this->belongsTo(RoomMaster::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function stayingPlans()
    {
        return $this->belongsToMany(StayingPlan::class, 'reservation_slot_staying_plans');
    }

    public function scopeLatestOrder($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }
}
