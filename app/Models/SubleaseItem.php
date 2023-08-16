<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubleaseItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sublease_id',
        'os_product_id',
        'group_id',
        'provider_id',
        'quantity',
        'status',
    ];

    public function sublease()
    {
        return $this->belongsTo(Sublease::class);
    }

    public function osProduct()
    {
        return $this->belongsTo(OSProduct::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
