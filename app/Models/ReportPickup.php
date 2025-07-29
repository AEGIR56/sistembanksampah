<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportPickup extends Model
{
    protected $table = 'report_pickups';

    protected $fillable = [
        'pickup_id',
        'staff_id',
        'berat_staff',
        'alasan_laporan',
        'gambar_1',
        'gambar_2',
        'gambar_3',
        'catatan',
        'status_laporan',
    ];
    public const STATUS_SELESAI = 'pickup selesai';

    public function pickup()
    {
        return $this->belongsTo(Pickup::class,'pickup_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
