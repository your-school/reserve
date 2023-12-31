<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRoom extends Model
{
    use HasFactory;

    protected $table = 'plan_rooms'; // テーブル名を指定

    protected $fillable = [
        'plan_id',
        'room_slot_id',
        'price',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function roomSlot()
    {
        return $this->belongsTo(RoomSlot::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'plan_room_reservations');
    }
}
