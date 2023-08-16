<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sublease extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_service_id',
        'status',
    ];

    public function orderService()
    {
        return $this->belongsTo(OrderService::class);
    }

    public function items()
    {
        return $this->hasMany(SubleaseItem::class);
    }
}
