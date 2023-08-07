<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'customer_contact_id' => 'required|exists:customer_contacts,id',
            'place_id' => 'nullable|exists:places,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'name' => 'required',
            'request_date' => 'required',
            'budget_days' => 'required',
            'mount_date' => 'nullable',
            'unmount_date' => 'nullable',
            'start_time' => 'required',
            'end_time' => 'required',
            'public' => 'nullable',
            'commercial_conditions' => 'nullable',
            'payment_conditions' => 'nullable',
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_id' => 'cliente',
            'customer_contact_id' => 'contato',
            'place_id' => 'local',
            'agency_id' => 'agência',
            'name' => 'nome do evento',
            'request_date' => 'data da solicitação',
            'budget_days' => 'dias do evento',
            'mount_date' => 'data de montagem',
            'unmount_date' => 'data de desmontagem',
            'start_time' => 'horário de início',
            'end_time' => 'horário de término',
            'public' => 'quantidade de participantes',
            'commercial_conditions' => 'condições comerciais',
            'payment_conditions' => 'condições de pagamento',
        ];
    }
}
