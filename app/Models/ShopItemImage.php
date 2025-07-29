<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItemImage extends Model
{
    protected $fillable = ['image_path', 'shop_item_id'];

    public function shopItem()
    {
        return $this->belongsTo(ShopItem::class);
    }
}
