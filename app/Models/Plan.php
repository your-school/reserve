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

    // プラン削除時、紐づくデータの削除
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($plan) {
            foreach ($plan->planImages as $image) {
                $image->delete();
            }
            foreach ($plan->planRooms as $planRoom) {
                $planRoom->delete();
            }
        });
    }

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
