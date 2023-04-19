<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BriefingOnlineRequest extends FormRequest
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
        ];
    }
}
