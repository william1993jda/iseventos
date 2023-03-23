<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'active',
    ];

    public function products()
    {
        return $this->hasMany(GroupProduct::class);
    }
}
