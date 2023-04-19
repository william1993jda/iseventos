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
            'type_event' => 'required',
            'room' => 'required',
            'company' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'start_date_rehearsal' => 'nullable',
            'end_date_rehearsal' => 'nullable',
            'start_date_event' => 'nullable',
            'end_date_event' => 'nullable',
            'pax' => 'nullable',
            'du' => 'nullable',
            'focal_point' => 'nullable',
            'agency_name' => 'nullable',
            'agency_contact' => 'nullable',
            'agency_phone' => 'nullable',
            'agency_email' => 'nullable',
            'agency_production' => 'nullable',
            'agency_criation' => 'nullable',
            'agency_logistic' => 'nullable',
            'room_quantity' => 'nullable',
            'room_format' => 'nullable',
            'room_description' => 'nullable',
            'armchair' => 'nullable',
            'armchair_quantity' => 'nullable',
            'armchair_description' => 'nullable',
            'pulpit' => 'nullable',
            'pulpit_quantity' => 'nullable',
            'pulpit_description' => 'nullable',
            'table' => 'nullable',
            'table_quantity' => 'nullable',
            'table_description' => 'nullable',
            'lounge' => 'nullable',
            'lounge_quantity' => 'nullable',
            'lounge_description' => 'nullable',
            'others' => 'nullable',
            'others_description' => 'nullable',
            'screen' => 'nullable',
            'lighting_decorative' => 'nullable',
            'lighting_foyer' => 'nullable',
            'lighting_restaurant' => 'nullable',
            'lighting_stage' => 'nullable',
            'lighting_audience' => 'nullable',
            'lighting_effects' => 'nullable',
            'sound_room' => 'nullable',
            'sound_foyer' => 'nullable',
            'sound_restaurant' => 'nullable',
            'microphone_quantity' => 'nullable',
            'translation' => 'nullable',
            'languages' => 'nullable',
            'amount_radio' => 'nullable',
            'description_translation' => 'nullable',
            'recommendation_translation' => 'nullable',
            'name_interpreter' => 'nullable',
            'phone_interpreter' => 'nullable',
            'additional_description' => 'nullable',
            'observation_description' => 'nullable',
            'platform_transmission' => 'nullable',
            'link_event' => 'nullable',
            'site_landing' => 'nullable',
            'social_network' => 'nullable',
            'speaker' => 'nullable',
            'speaker_quantity' => 'nullable',
            'speaker_description' => 'nullable',
            'artistic_direction' => 'nullable',
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
            'studio_amount' => 'nullable',
            'studio_type' => 'nullable',
        ];
    }
}
