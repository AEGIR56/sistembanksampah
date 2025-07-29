<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'user_id',
        'pickup_date',
        'time_slot',
        'address',
        'waste_type_id',
        'weight',
        'status',
        'staff_id',
    ];

    public const STATUS_PENDING = 'menunggu';
    public const STATUS_PROCESSING = 'diproses';
    public const STATUS_PICKUP_DONE = 'pickup selesai';
    public const STATUS_PICKUP_REJECTED = 'pickup ditolak';
    public const STATUS_APPROVED = 'selesai';
    public const STATUS_REJECTED = 'gagal_admin';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');

    }
    public function report()
    {
        return $this->hasOne(ReportPickup::class);
    }
    
    public function wasteType()
    {
        return $this->belongsTo(WasteType::class, 'waste_type_id');

    }



}
