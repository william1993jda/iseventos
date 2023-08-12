<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'os_status_id',
        'budget_id',
        'os_number',
        'os_version',
        'budget_version',
        'observation',
    ];


    public function osStatus()
    {
        return $this->belongsTo(OsStatus::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function expenses()
    {
        return $this->hasMany(OrderServiceExpense::class);
    }

    public function documents()
    {
        return $this->hasMany(OrderServiceDocument::class);
    }

    public function products()
    {
        return $this->hasMany(OrderServiceRoomProduct::class);
    }

    public function groups()
    {
        return $this->hasMany(OrderServiceRoomGroup::class);
    }
}
