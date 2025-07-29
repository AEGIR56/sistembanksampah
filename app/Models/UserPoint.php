<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    protected $fillable = ['user_id', 'pickup_id', 'points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickup()
    {
        return $this->belongsTo(Pickup::class);
    }
}
