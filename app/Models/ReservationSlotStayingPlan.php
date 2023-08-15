<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlotStayingPlan extends Model
{
    use HasFactory;

    protected $table = 'reservation_slot_staying_plans'; // テーブル名を指定

    protected $fillable = [
        'staying_plan_id',
        'reservation_slot_id',
        'price',
    ];

    public function stayingPlan()
    {
        return $this->belongsTo(StayingPlan::class);
    }
}
