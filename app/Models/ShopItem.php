<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'point_cost', 'stock'];

    public function images()
    {
        return $this->hasMany(ShopItemImage::class);
    }

    public function transactions()
    {
        return $this->hasMany(PointShopTransaction::class);
    }
}
