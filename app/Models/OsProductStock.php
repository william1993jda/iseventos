<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OsProductStock extends Model
{
    use HasFactory, SoftDeletes;

    const STATUSES = [
        '' => 'Selecione...',
        '1' => 'Ativo',
        '2' => 'Manutenção',
        '3' => 'Outro',
    ];

    protected $fillable = [
        'os_product_id',
        'sku',
        'price',
        'accessories',
        'purchase_date',
        'life_date',
        'status',
        'active',
    ];

    public function setPriceAttribute($value)
    {
        if ($value) {
            $price = str_replace('.', '', $value);
            $price = str_replace(',', '.', $price);

            $this->attributes['price'] = $price;
        }
    }

    public function getPriceAttribute()
    {
        return number_format($this->attributes['price'], 2, ',', '.');
    }

    public function setPurchaseDateAttribute($value)
    {
        if ($value) {
            $this->attributes['purchase_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        }
    }

    public function setLifeDateAttribute($value)
    {
        if ($value) {
            $this->attributes['life_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        }
    }

    public function getStatus()
    {
        if ($this->status) {
            return self::STATUSES[$this->status];
        }
    }

    public function osProduct()
    {
        return $this->belongsTo(OsProduct::class);
    }

    // public function getPriceFormated()
    // {
    //     return number_format($this->attributes['price'], 2, ',', '.');
    // }
}
