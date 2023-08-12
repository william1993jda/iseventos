<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OsProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'os_category_id',
        'provider_id',
        'name',
        'customization',
        'price',
        'active',
        'brand',
        'model',
        'serie',
        'dimensions',
        'weight',
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

    public function stocks()
    {
        return $this->hasMany(OsProductStock::class);
    }

    public function category()
    {
        return $this->belongsTo(OsCategory::class, 'os_category_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    public function getActive()
    {
        if (!empty($this->attributes['id'])) {
            return $this->attributes['active'] ? true : false;
        }

        return true;
    }

    public function getCustomization()
    {
        if (!empty($this->attributes['id'])) {
            return $this->attributes['customization'] ? true : false;
        }

        return $this->attributes['customization'] = true;
    }
}
