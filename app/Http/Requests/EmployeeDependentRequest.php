<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeDependentRequest extends FormRequest
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
            'birthday' => 'nullable|string|max:255',
            'identification' => 'nullable|string|max:255',
            'social_security' => 'nullable|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'birthday' => 'data de nascimento',
            'identification' => 'parentesco',
            'social_security' => 'cpf',
        ];
    }
}
