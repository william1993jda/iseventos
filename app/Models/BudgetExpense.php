<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetExpense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'budget_id',
        'name',
        'description',
        'price',
        'date',
    ];

    public function setPriceAttribute($value)
    {
        $price = str_replace('.', '', $value);
        $price = str_replace(',', '.', $price);

        $this->attributes['price'] = $price;
    }

    public function getPriceFormated()
    {
        return number_format($this->attributes['price'], 2, ',', '.');
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
    }

    public function getDateAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['date']));
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }
}
