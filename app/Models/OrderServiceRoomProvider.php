<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderServiceRoomProvider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_service_id',
        'place_room_id',
        'os_product_id',
        'days',
        'quantity',
    ];

    public function orderService()
    {
        return $this->belongsTo(OrderService::class);
    }

    public function placeRoom()
    {
        return $this->belongsTo(PlaceRoom::class);
    }

    public function osProduct()
    {
        return $this->belongsTo(OsProduct::class);
    }
}
