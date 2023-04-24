<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BriefingPerson extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'briefing_persons';

    protected $fillable = [
        'armchair',
        'armchair_quantity',
        'armchair_description',
        'pulpit',
        'pulpit_quantity',
        'pulpit_description',
        'table',
        'table_description',
        'lounge',
        'lounge_description',
        'others',
        'screen',
        'lighting_decorative',
        'lighting_foyer',
        'lighting_restaurant',
        'lighting_stage',
        'lighting_effects',
        'sound_room',
        'sound_foyer',
        'sound_restaurant',
        'microphone_quantity',
        'translation',
        'translation_comments',
        'languages',
        'radio_quantity',
        'name_interpreter',
        'phone_interpreter',
        'additionals',
        'observations',
    ];

    public function setLanguagesAttribute($value)
    {
        $this->attributes['languages'] = implode('#@#', $value);
    }

    public function getLanguagesAttribute($value)
    {
        return explode('#@#', $value);
    }

    public function setAdditionalsAttribute($value)
    {
        $additionals = [];

        foreach ($value as $key => $item) {
            if ($item == '1') {
                $key = str_replace("'", "", $key);
                array_push($additionals, $key);
            }
        }

        $this->attributes['additionals'] = implode('#@#', $additionals);
    }

    public function getAdditionalsAttribute($value)
    {
        return explode('#@#', $value);
    }

    public function briefing()
    {
        return $this->belongsTo(Briefing::class);
    }

    public function rooms()
    {
        return $this->hasMany(BriefingPersonRoom::class);
    }
}
