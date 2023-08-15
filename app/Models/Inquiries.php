<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\InquiryRequest;

class Inquiries extends Model
{
    use HasFactory;
    protected $table = 'inquiries';
    protected $fillable = ['first_name','last_name','email','inquiry_category','content','status'];

    public function scopeLatestOrder($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }
}
