<?php

namespace App\Http\Requests;

use App\Rules\UniqueEmailFreelancerRule;
use Illuminate\Foundation\Http\FormRequest;

class FreelancerRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'birthday' => 'required|string',
            'admission_date' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'cellphone' => 'nullable|string|max:255',
            'identification' => 'nullable|string|max:255',
            'social_security' => 'nullable|string|max:255',
            'emergency_name' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:255',
            'occupation_area' => 'nullable|string|max:255',
            'ein' => 'nullable|string|max:255',
            'corporate_name' => 'nullable|string|max:255',
            'fantasy_name' => 'nullable|string|max:255',
            'cnai' => 'nullable|string|max:255',
            'tshirt' => 'nullable|string|max:255',
            'trousers' => 'nullable|string|max:255',
            'shoe' => 'nullable|string|max:255',
            'observation' => 'nullable|string|max:255',
            'work_card' => 'nullable|string|max:255',
            'reservist' => 'nullable|string|max:255',
            'voter_registration' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_identification' => 'nullable|string|max:255',
            'spouse_social_security' => 'nullable|string|max:255',
            'spouse_birth_date' => 'nullable|string',
            'contract' => 'nullable|string|max:255',
            'labor_id' => 'required',
            'price' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'birthday' => 'data de nascimento',
            'admission_date' => 'data de admissão',
            'phone' => 'telefone',
            'cellphone' => 'celular',
            'identification' => 'rg',
            'social_security' => 'cpf',
            'emergency_name' => 'contato de emergência',
            'emergency_phone' => 'telefone de emergência',
            'occupation_area' => 'área de ocupação',
            'ein' => 'cnpj',
            'corporate_name' => 'razão social',
            'fantasy_name' => 'nome fantasia',
            'cnai' => 'cnai',
            'tshirt' => 'tamanho camiseta',
            'trousers' => 'tamanho calça',
            'shoe' => 'tamanho sapato',
            'observation' => 'observação',
            'work_card' => 'carteira de trabalho',
            'reservist' => 'certificado de reservista',
            'voter_registration' => 'título de eleitor',
            'spouse_name' => 'nome do cônjuge',
            'spouse_identification' => 'rg do cônjuge',
            'spouse_social_security' => 'cpf do cônjuge',
            'spouse_birth_date' => 'data de nascimento do cônjuge',
            'contract' => 'contrato',
            'labor_id' => 'mão de obra',
            'price' => 'preço',
        ];
    }
}
