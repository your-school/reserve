<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_slot_staying_plan_id',
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
        'admin_memo'
    ];


    public function reservationSlots()
    {
        return $this->hasMany(ReservationSlot::class);
    }

    public function reservationSlotStayingPlans()
    {
        return $this->HasMany(ReservationSlotStayingPlan::class, 'staying_plan_id');
    }
}
