<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProviderContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'provider_id',
        'name',
        'email',
        'phone',
        'observation',
    ];
}
