<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRoomReservation extends Model
{
    use HasFactory;

    protected $table = 'plan_room_reservations'; // テーブル名を指定

    protected $fillable = [
        'reservation_id',
        'plan_room_id',
    ];

    public function planRoom()
    {
        return $this->belongsTo(PlanRoom::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
