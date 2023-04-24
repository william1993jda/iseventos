<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'active',
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

    public function getActive()
    {
        if (!empty($this->attributes['id'])) {
            return $this->attributes['active'] ? true : false;
        }

        return $this->attributes['active'] = true;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
