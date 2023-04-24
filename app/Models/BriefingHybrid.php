<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BriefingHybrid extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'armchair',
        'armchair_quantity',
        'armchair_description',
        'pulpit',
        'pulpit_quantity',
        'pulpit_description',
        'table',
        'table_quantity',
        'table_description',
        'lounge',
        'lounge_quantity',
        'lounge_description',
        'others',
        'others_description',
        'screen',
        'lighting_decorative',
        'lighting_foyer',
        'lighting_restaurant',
        'lighting_stage',
        'lighting_audience',
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
        'platform_transmission',
        'link_event',
        'site_landing',
        'social_network',
        'speaker',
        'speaker_quantity',
        'speaker_description',
        'speaker_studio',
        'speaker_studio_quantity',
        'speaker_studio_description',
        'direction',
        'direction_quantity',
        'direction_description',
        'rehearsal',
        'rehearsal_address',
        'recording',
        'recording_address',
        'teleprompter',
        'teleprompter_quantity',
        'ipad',
        'ipad_quantity',
        'ipad_description',
        'studio_local',
        'studio_room',
        'studio_speakers_quantity',
        'studio_type',
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
        return $this->hasMany(BriefingHybridRoom::class);
    }
}
