<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OsCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'active',
    ];

    public function products()
    {
        return $this->hasMany(OsProduct::class);
    }

    public function getActive()
    {
        if (!empty($this->attributes['id'])) {
            return $this->attributes['active'] ? true : false;
        }

        return $this->attributes['active'] = true;
    }
}
