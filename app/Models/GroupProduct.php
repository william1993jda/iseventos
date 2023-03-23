<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GroupProduct extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'group_id',
        'os_product_id',
    ];


    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function product()
    {
        return $this->belongsTo(OsProduct::class, 'os_product_id');
    }
}
