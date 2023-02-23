<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'corporate_name',
        'fantasy_name',
        'ein',
        'email',
        'phone',
        'occupation_area',
        'logo',
        'observation',
    ];

    public function contacts()
    {
        return $this->hasMany(ProviderContact::class);
    }

    public function addresses()
    {
        return $this->hasMany(ProviderAddress::class);
    }

    public function banks()
    {
        return $this->hasMany(ProviderBank::class);
    }
}
