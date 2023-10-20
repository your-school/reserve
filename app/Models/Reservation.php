<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'number_of_people',
        'email',
        'phone_number',
        'post_code',
        'address',
        'message',
        'start_day',
        'end_day',
        'total_price',
        'admin_memo',
        'cancel',
    ];

    public function planRooms()
    {
        return $this->belongsToMany(PlanRoom::class, 'plan_room_reservations');
    }
}
