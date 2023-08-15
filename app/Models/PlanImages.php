<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'staying_plan_id',
        'image_path',
    ];

    public function stayingPlan()
    {
        return $this->belongsTo(StayingPlan::class);
    }
}
