<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class PlaceDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'place_id',
        'name',
        'url',
    ];

    public function getLink()
    {
        return Storage::disk('s3')->url($this->url);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
