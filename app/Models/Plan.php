<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
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

    public function roomSlots()
    {
        return $this->belongsToMany(RoomSlot::class, 'plan_rooms')->withPivot('id', 'price');
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
