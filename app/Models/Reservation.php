<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    // 予約削除時、紐づくデータの削除
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($reservation) {
            foreach ($reservation->planRoomReservations as $planRoomReservation) {
                $planRoomReservation->delete();
            }
        });
    }

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

    public function planRooms(): BelongsToMany
    {
        return $this->belongsToMany(PlanRoom::class, 'plan_room_reservations');
    }

    public function planRoomReservations(): HasMany
    {
        return $this->hasMany(PlanRoomReservation::class);
    }
}
