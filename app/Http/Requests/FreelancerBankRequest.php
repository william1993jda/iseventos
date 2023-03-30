<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreelancerBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:255',
            'agency' => 'required|string|max:255',
            'account' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'holder' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'observation' => 'nullable|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'banco',
            'number' => 'número do banco',
            'agency' => 'agência',
            'account' => 'número da conta',
            'type' => 'tipo',
            'holder' => 'nome do titular da conta',
            'document_number' => 'CPF ou CNPJ do titular',
            'observation' => 'observação',
        ];
    }
}
