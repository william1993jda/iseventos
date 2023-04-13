<?php

namespace App\Http\Requests;

use App\Rules\UniqueEmailEmployeeRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'payment_term' => 'nullable|string|max:255',
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
            'payment_term' => 'prazo de pagamento'
        ];
    }
}
