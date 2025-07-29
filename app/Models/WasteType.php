<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    protected $table = 'waste_types';

    protected $fillable = [
        'name',
        'price_per_kg',
        'points_per_kg',
    ];

    public $timestamps = true;
}
