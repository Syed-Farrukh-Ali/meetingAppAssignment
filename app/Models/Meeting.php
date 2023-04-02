<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function attendee1()
    {
        return $this->belongsTo(User::class, 'attendee1_id');
    }
    public function attendee2()
    {
        return $this->belongsTo(User::class, 'attendee2_id');
    }
}
