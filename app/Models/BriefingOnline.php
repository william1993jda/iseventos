<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BriefingOnline extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'briefing_id',
        'platform_transmission',
        'link_event',
        'site_landing',
        'social_network',
        'speaker',
        'speaker_quantity',
        'speaker_description',
        'direction',
        'direction_quantity',
        'direction_description',
        'rehearsal',
        'rehearsal_address',
        'recording',
        'recording_address',
        'translation',
        'translation_comments',
        'languages',
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
}
