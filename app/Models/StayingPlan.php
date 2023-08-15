<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StayingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'explain',
    ];
    
    public function planImages()
    {
        return $this->HasMany(PlanImages::class);
    }

    public function reservationSlots()
    {
        return $this->belongsToMany(ReservationSlot::class, 'reservation_slot_staying_plans');
    }

    public function reservationSlotStayingPlans()
    {
        return $this->HasMany(ReservationSlotStayingPlan::class, 'staying_plan_id');
    }

    public function scopeLatestOrder($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }        
}
