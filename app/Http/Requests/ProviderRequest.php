<?php

namespace App\Http\Requests;

use App\Rules\UniqueEmailEmployeeRule;
use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
            'corporate_name' => 'nullable|string|max:255',
            'fantasy_name' => 'required|string|max:255',
            'ein' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|string|max:255',
            'occupation_area' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'observation' => 'nullable|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'razão social',
            'fantasy_name' => 'nome fantasia',
            'ein' => 'cnpj',
            'email' => 'e-mail',
            'phone' => 'telefone',
            'occupation_area' => 'área de atuação',
            'logo' => 'logo',
            'observation' => 'observação',
        ];
    }
}
