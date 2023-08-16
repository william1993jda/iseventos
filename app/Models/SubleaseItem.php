<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubleaseItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sublease_id',
        'os_product_id',
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
}
