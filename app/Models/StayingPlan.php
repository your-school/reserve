<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StayingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'explain',
    ];

    public function planImages()
    {
        return $this->HasMany(PlanImages::class);
    }

    public function reservationSlots()
    {
        return $this->belongsToMany(ReservationSlot::class, 'reservation_slot_staying_plans')->withPivot('id', 'price');
    }

    public function scopeLatestOrder($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }
}
