<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class OrderServiceCheck extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_service_id',
        'status',
        'observation',
    ];

    public function orderService()
    {
        return $this->belongsTo(OrderService::class);
    }
}
