<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class OrderServiceCheckItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_service_check_id',
        'order_service_room_product_id',
        'os_product_id',
        'group_id',
        'os_product_stock_id',
        'checkout_date',
        'checkin_date',
        'status',
        'observation',
    ];

    protected $casts = [
        'checkout_date' => 'date',
        'checkin_date' => 'date',
    ];

    public function orderService()
    {
        return $this->belongsTo(OrderService::class);
    }

    public function orderServiceCheck()
    {
        return $this->belongsTo(OrderServiceCheck::class);
    }

    public function orderServiceRoomProduct()
    {
        return $this->belongsTo(OrderServiceRoomProduct::class);
    }

    public function osProduct()
    {
        return $this->belongsTo(OsProduct::class);
    }

    public function osProductStock()
    {
        return $this->belongsTo(OsProductStock::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
