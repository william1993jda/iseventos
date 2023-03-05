<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'corporate_name',
        'fantasy_name',
        'ein',
        'email',
        'phone',
    ];

    public function contacts()
    {
        return $this->hasMany(AgencyContact::class);
    }

    public function addresses()
    {
        return $this->hasMany(AgencyAddress::class);
    }
}
