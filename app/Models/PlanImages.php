<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'image_path',
        'image_url',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
