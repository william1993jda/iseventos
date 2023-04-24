<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BriefingHybridRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'local' => 'required',
            'company' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'start_date_mount' => 'nullable',
            'end_date_mount' => 'nullable',
            'start_date_rehearsal' => 'nullable',
            'end_date_rehearsal' => 'nullable',
            'start_date_event' => 'nullable',
            'end_date_event' => 'nullable',
            'public' => 'nullable',
            'bu' => 'nullable',
            'focal_point' => 'nullable',
            'agency_name' => 'nullable',
            'agency_contact' => 'nullable',
            'agency_phone' => 'nullable',
            'agency_email' => 'nullable',
            'agency_production' => 'nullable',
            'agency_criation' => 'nullable',
            'agency_logistic' => 'nullable',
            'room_name' => 'nullable',
            'room_format' => 'nullable',
            'room_description' => 'nullable',
            'armchair' => 'nullable',
            'armchair_quantity' => 'nullable',
            'armchair_description' => 'nullable',
            'pulpit' => 'nullable',
            'pulpit_quantity' => 'nullable',
            'pulpit_description' => 'nullable',
            'table' => 'nullable',
            'table_description' => 'nullable',
            'lounge' => 'nullable',
            'lounge_description' => 'nullable',
            'others' => 'nullable',
            'screen' => 'nullable',
            'lighting_decorative' => 'nullable',
            'lighting_foyer' => 'nullable',
            'lighting_restaurant' => 'nullable',
            'lighting_stage' => 'nullable',
            'lighting_effects' => 'nullable',
            'sound_room' => 'nullable',
            'sound_foyer' => 'nullable',
            'sound_restaurant' => 'nullable',
            'microphone_quantity' => 'nullable',
            'translation' => 'nullable',
            'translation_comments' => 'nullable',
            'languages' => 'nullable',
            'radio_quantity' => 'nullable',
            'name_interpreter' => 'nullable',
            'phone_interpreter' => 'nullable',
            'platform_transmission' => 'nullable',
            'link_event' => 'nullable',
            'site_landing' => 'nullable',
            'social_network' => 'nullable',
            'speaker' => 'nullable',
            'speaker_quantity' => 'nullable',
            'speaker_description' => 'nullable',
            'speaker_studio' => 'nullable',
            'speaker_studio_quantity' => 'nullable',
            'speaker_studio_description' => 'nullable',
            'direction' => 'nullable',
            'direction_quantity' => 'nullable',
            'direction_description' => 'nullable',
            'rehearsal' => 'nullable',
            'rehearsal_address' => 'nullable',
            'recording' => 'nullable',
            'recording_address' => 'nullable',
            'teleprompter' => 'nullable',
            'teleprompter_quantity' => 'nullable',
            'ipad' => 'nullable',
            'ipad_quantity' => 'nullable',
            'ipad_description' => 'nullable',
            'studio_local' => 'nullable',
            'studio_room' => 'nullable',
            'studio_speakers_quantity' => 'nullable',
            'studio_type' => 'nullable',
            'additionals' => 'nullable',
            'observations' => 'nullable',
        ];
    }
}
