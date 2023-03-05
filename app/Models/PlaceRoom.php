<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'place_id',
        'name',
        'active',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function documents()
    {
        return $this->hasMany(PlaceRoomDocument::class);
    }
}
