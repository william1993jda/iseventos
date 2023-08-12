<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetRoomProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'budget_id',
        'place_room_id',
        'product_id',
        'days',
        'price',
        'bv',
        'quantity',
    ];

    public function setPriceAttribute($value)
    {
        $price = str_replace('.', '', $value);
        $price = str_replace(',', '.', $price);

        $this->attributes['price'] = $price;
    }

    // public function getPriceAttribute()
    // {
    //     return number_format($this->attributes['price'], 2, ',', '.');
    // }

    // public function getPriceFormated()
    // {
    //     return number_format($this->attributes['price'], 2, ',', '.');
    // }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function placeRoom()
    {
        return $this->belongsTo(PlaceRoom::class, 'place_room_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
