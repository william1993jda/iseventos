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
            'platform_transmission' => 'nullable',
            'link_event' => 'nullable',
            'site_landing' => 'nullable',
            'social_network' => 'nullable',
            'speaker' => 'nullable',
            'speaker_quantity' => 'nullable',
            'speaker_description' => 'nullable',
            'direction' => 'nullable',
            'direction_quantity' => 'nullable',
            'direction_description' => 'nullable',
            'rehearsal' => 'nullable',
            'rehearsal_address' => 'nullable',
            'recording' => 'nullable',
            'recording_address' => 'nullable',
            'translation' => 'nullable',
            'translation_comments' => 'nullable',
            'languages' => 'nullable',
            'additionals' => 'nullable',
            'observations' => 'nullable',
        ];
    }
}
