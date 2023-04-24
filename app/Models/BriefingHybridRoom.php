<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BriefingHybridRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'briefing_hybrid_rooms';

    protected $fillable = [
        'briefing_hybrid_id',
        'name',
        'room_format',
        'comments'
    ];

    public function briefingHybrid()
    {
        return $this->belongsTo(BriefingHybrid::class);
    }
}
