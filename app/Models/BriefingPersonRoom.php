<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BriefingPersonRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'briefing_person_rooms';

    protected $fillable = [
        'briefing_person_id',
        'name',
        'room_format',
        'comments'
    ];

    public function briefingPerson()
    {
        return $this->belongsTo(BriefingPerson::class);
    }
}
