<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BriefingOnline extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
    ];
}
