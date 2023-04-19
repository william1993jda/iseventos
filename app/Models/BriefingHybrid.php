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
        'languages',
        'amount_radio',
        'description_translation',
        'recommendation_translation',
        'name_interpreter',
        'phone_interpreter',
        'additional_description',
        'observation_description',
        'platform_transmission',
        'link_event',
        'site_landing',
        'social_network',
        'speaker',
        'speaker_quantity',
        'speaker_description',
        'artistic_direction',
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
        'studio_amount',
        'studio_type',
    ];
}
