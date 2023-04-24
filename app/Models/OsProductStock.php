<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OsProductStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'os_product_id',
        'sku',
        'price',
        'active',
        'accessories',
        'purchase_date',
        'status',
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
}
