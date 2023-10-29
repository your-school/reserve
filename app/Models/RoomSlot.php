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

    // 予約枠削除時、紐づくデータの削除
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($roomSlot) {
            foreach ($roomSlot->planRooms as $planRoom) {
                $planRoom->delete();
            }
        });
    }

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
