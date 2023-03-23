<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BudgetDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'budget_id',
        'name',
        'url',
    ];

    public function getLink()
    {
        return Storage::disk('s3')->url($this->url);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
