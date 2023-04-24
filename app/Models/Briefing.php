<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Briefing extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_EVENT = [
        1 => 'Online',
        2 => 'Presencial',
        3 => 'Híbrido',
    ];

    protected $fillable = [
        'name',
        'local',
        'type_event',
        'company',
        'email',
        'phone',
        'start_date_mount',
        'end_date_mount',
        'start_date_rehearsal',
        'end_date_rehearsal',
        'start_date_event',
        'end_date_event',
        'public',
        'bu',
        'focal_point',
        'agency_name',
        'agency_contact',
        'agency_phone',
        'agency_email',
        'agency_production',
        'agency_criation',
        'agency_logistic',
    ];

    public function setStartDateMountAttribute($value)
    {
        $this->attributes['start_date_mount'] = implode('-', array_reverse(explode('/', $value)));
    }

    public function setEndDateMountAttribute($value)
    {
        $this->attributes['end_date_mount'] = implode('-', array_reverse(explode('/', $value)));
    }

    public function setStartDateRehearsalAttribute($value)
    {
        $this->attributes['start_date_rehearsal'] = implode('-', array_reverse(explode('/', $value)));
    }

    public function setEndDateRehearsalAttribute($value)
    {
        $this->attributes['end_date_rehearsal'] = implode('-', array_reverse(explode('/', $value)));
    }

    public function setStartDateEventAttribute($value)
    {
        $this->attributes['start_date_event'] = implode('-', array_reverse(explode('/', $value)));
    }

    public function setEndDateEventAttribute($value)
    {
        $this->attributes['end_date_event'] = implode('-', array_reverse(explode('/', $value)));
    }

    public function getEventType()
    {
        return self::TYPE_EVENT[$this->type_event];
    }

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
