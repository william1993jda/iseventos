<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderServiceRoomLabor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_service_id',
        'place_room_id',
        'labor_id',
        'days',
        'price',
        'quantity',
    ];

    public function setPriceAttribute($value)
    {
        $price = str_replace('.', '', $value);
        $price = str_replace(',', '.', $price);

        $this->attributes['price'] = $price;
    }

    public function getPriceAttribute()
    {
        return number_format($this->attributes['price'], 2, ',', '.');
    }

    // public function getPriceFormated()
    // {
    //     return number_format($this->attributes['price'], 2, ',', '.');
    // }

    public function orderService()
    {
        return $this->belongsTo(OrderService::class, 'order_service_id');
    }

    public function placeRoom()
    {
        return $this->belongsTo(PlaceRoom::class, 'place_room_id');
    }

    public function labor()
    {
        return $this->belongsTo(Labor::class, 'labor_id');
    }
}
