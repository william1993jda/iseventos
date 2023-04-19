<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Briefing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'local',
        'type_event',
        'room',
        'company',
        'email',
        'phone',
        'start_date_rehearsal',
        'end_date_rehearsal',
        'start_date_event',
        'end_date_event',
        'pax',
        'du',
        'focal_point',
        'agency_name',
        'agency_contact',
        'agency_phone',
        'agency_email',
        'agency_production',
        'agency_criation',
        'agency_logistic',
        'room_quantity',
        'room_format',
        'room_description',
    ];

    public function online()
    {
        return $this->hasOne(BriefingOnline::class);
    }

    public function person()
    {
        return $this->hasOne(BriefingPerson::class);
    }

    public function hybrid()
    {
        return $this->hasOne(BriefingHybrid::class);
    }
}
