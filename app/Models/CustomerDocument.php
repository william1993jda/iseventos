<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CustomerDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'name',
        'url',
    ];

    public function getLink()
    {
        return Storage::disk('s3')->url($this->url);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
