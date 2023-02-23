<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgencyContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agency_id',
        'name',
        'email',
        'phone',
        'observation',
    ];
}
