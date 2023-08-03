<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderServiceRequest extends FormRequest
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
            // 'os_status_id' => 'required|exists:os_statuses,id',
            'budget_id' => 'required|exists:budgets,id',
            'observation' => 'nullable',
        ];
    }

    public function attributes(): array
    {
        return [
            'os_status_id' => 'status',
            'budget_id' => 'orçamento',
            'observation' => 'observação',
        ];
    }
}
