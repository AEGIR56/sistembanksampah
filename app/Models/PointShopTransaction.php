<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointShopTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'shop_item_id',
        'quantity',
        'point_used',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shopItem()
    {
        return $this->belongsTo(ShopItem::class);
    }
}
